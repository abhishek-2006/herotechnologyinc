<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "UPDATE user_master SET password='$password' WHERE email='$email'";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        header("Location: ../login.php?reset=success");
        exit;
    } else {
        header("Location: ../forgot-password.php?error=updatefailed");
        exit;
    }
} else {
    header("Location: ../forgot-password.php?error=notfound");
    exit;
}

    $conn->close();
?>
