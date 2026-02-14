<?php
require '../config.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['email'];
$name = mysqli_real_escape_string($conn, $_POST['name']);
$password = $_POST['password'];

if (!empty($password)) {
    $hashed_password = md5($password);
    $sql = "UPDATE user_master SET 
            name = '$name', 
            password = '$hashed_password' 
            WHERE email = '$email'";
} else {
    $sql = "UPDATE user_master SET 
            name = '$name'
            WHERE email = '$email'";
}

if (mysqli_query($conn, $sql)) {
    $_SESSION['name'] = $name;
    
    header("Location: ../profile.php?status=sync_complete");
} else {
    header("Location: ../profile.php?status=sync_error");
}
exit();
?>