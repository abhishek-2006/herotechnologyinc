<?php
require '../config.php';

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header('Location: ../login.php');
    exit();
}

if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha'] || empty($_SESSION['captcha'])) {
    echo "<script>
            alert('Invalid Captcha. Access Denied.'); 
            window.location='../login.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identifier = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM user_master WHERE (email='$identifier' OR username='$identifier') AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        $user_id = $row['user_id'];
        $role = $row['role'];
        $ip = $_SERVER['REMOTE_ADDR'];

        // 1. Log activity for security tracking
        $log_msg = ucfirst($role) . " Logged In";
        $qry = "INSERT INTO login_tracking (user_id, ip_address, content, is_online)
                VALUES ('$user_id', '$ip', '$log_msg', 'online')";
        mysqli_query($conn, $qry);

        // 2. Conditional Redirection Based on Role
        if ($role === 'student') {
            header('Location: ../dashboard.php');
        } elseif ($role === 'admin') {
            header('Location: ../backpanel/dashboard.php');
        } else {
            header('Location: ../login.php');
        }
        exit();

    } else {
        // Failure Fallback
        $error = "Invalid identity or access key.";
        echo "<script>
                alert('$error');
                window.location.href='../login.php';
              </script>";
        exit();
    }
}