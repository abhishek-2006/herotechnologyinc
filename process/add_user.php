<?php
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: ../signup.php');
    exit();
}

if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha'] || empty($_SESSION['captcha'])) {
    echo "<script>
            alert('Invalid Captcha. Access Denied.'); 
            window.location='../signup.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_captcha = $_POST['captcha'] ?? '';

    if ($user_captcha != $_SESSION['captcha'] OR $_SESSION['captcha'] == '') {
        echo "<script>
                alert('Incorrect Captcha. Access Denied.'); 
                window.location='../signup.php';
              </script>";
        exit();
    }

    unset($_SESSION['captcha']);

    // 2. Data Sanitization & Intelligence Gathering
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    
    $password = md5($_POST['password']);
    $confirmpassword = md5($_POST['confirmpassword']);

    // 3. Security Handshake (Password Match)
    if ($password !== $confirmpassword) {
        echo "<script>alert('Protocol Error: Passwords do not match.'); window.location='../signup.php';</script>";
        exit();
    }

    // 4. Duplicate Entry Check (Email & Username)
    $check_query = "SELECT email, username FROM user_master WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>
                alert('Email or Username already exists in the system.'); 
                window.location='../signup.php';
              </script>";
        exit();
    }

    // 5. Finalize User Deployment
    $sql = "INSERT INTO user_master (name, username, phone, email, gender, password) VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($insert_stmt, "ssssss", $name, $username, $phone, $email, $gender, $password);

    if (mysqli_stmt_execute($insert_stmt)) {
        
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;

        
        header("Location: ../security-questions.php");
        exit();
    } else {
        // Log system error
        error_log("Deployment Failure: " . mysqli_error($conn));
        echo "CRITICAL_SYSTEM_ERROR: Unable to deploy user node.";
    }
}
?>