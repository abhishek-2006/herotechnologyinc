<?php
require 'config.php';

$email = $_SESSION['email'];
$sql = "SELECT * FROM user_master WHERE email='$email' OR username='$email'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
$role = $row['role'];
$user_id = $row['user_id'];

if($role === 'manager'){
    $sql = "UPDATE login_tracking 
        SET is_online='offline', content='Manager Logged Out' 
        WHERE user_id='$user_id' 
        ORDER BY login_tracking_id DESC 
        LIMIT 1";

    mysqli_query($conn, $sql);
} elseif ($role === 'student') {
    $sql = "UPDATE login_tracking 
        SET is_online='offline', content='Student Logged Out' 
        WHERE user_id='$user_id' 
        ORDER BY login_tracking_id DESC 
        LIMIT 1";

    mysqli_query($conn, $sql);
}

unset($_SESSION);
session_destroy();
header("Location: index.php");
exit();
?>