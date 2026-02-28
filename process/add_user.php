<?php
// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Captcha Verification Node
    // die("User typed: " . $_POST['vercode'] . " | Session has: " . $_SESSION['vercode']);
    $user_vercode = $_POST['vercode'];
    if ($user_vercode != $_SESSION['vercode'] OR $_SESSION['vercode'] == '') {
        echo "<script>alert('Incorrect Captcha Code. Access Denied.'); window.location='../signup.php';</script>";
        exit();
    }

    unset($_SESSION['vercode']);

    // 2. Data Sanitization & Intelligence Gathering
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    
    // Use md5 as per your project standard
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
        echo "<script>alert('Identity Conflict: Email or Username already exists in the repository.'); window.location='../signup.php';</script>";
        exit();
    }

    // 5. Finalize User Deployment
    $sql = "INSERT INTO user_master (name, username, phone, email, gender, password) VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($insert_stmt, "ssssss", $name, $username, $phone, $email, $gender, $password);

    if (mysqli_stmt_execute($insert_stmt)) {
        // Success: Set Session Identifiers
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;

        // Redirect to next setup phase
        header("Location: ../security-questions.php");
        exit();
    } else {
        // Log system error
        error_log("Deployment Failure: " . mysqli_error($conn));
        echo "CRITICAL_SYSTEM_ERROR: Unable to deploy user node.";
    }
}
?>