<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['recovery_user_id'])) {
    
    $user_id = $_SESSION['recovery_user_id'];
    $password = md5($_POST['password']); 

    $sql = "UPDATE user_master SET password='$password' WHERE user_id='$user_id'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        unset($_SESSION['recovery_user_id']);
        header("Location: ../login.php?reset=success");
        exit();
    } else {
        header("Location: ../forgot-password.php?step=reset&error=The new password cannot be the same as the old one.");
        exit();
    }
} else {
    header("Location: ../forgot-password.php?error=Session expired. Please restart recovery.");
    exit();
}

$conn->close();
?>