<?php
session_start();
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize and Normalize Input
    $identifier = mysqli_real_escape_string($conn, trim($_POST['email']));
    
    // 2. Hash the incoming password with MD5
    $password = md5($_POST['password']);

    // 3. Resolve Identity: Verify both identifier and MD5 hash in one query
    $sql = "SELECT * FROM user_master WHERE (email='$identifier' OR username='$identifier') AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 4. Populate Identity Sessions for dashboard.php
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        $user_id = $row['user_id'];
        $role = $row['role'];
        $ip = $_SERVER['REMOTE_ADDR'];

        // 5. Log activity (Identity Tracking)
        $log_msg = ucfirst($role) . " Logged In";
        $qry = "INSERT INTO login_tracking (user_id, ip_address, content, is_online)
                VALUES ('$user_id', '$ip', '$log_msg', 'online')";
        mysqli_query($conn, $qry);

        // 6. Conditional Redirection Node
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
?>