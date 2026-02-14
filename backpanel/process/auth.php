<?php
require '../../config.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM user_master WHERE (username='$username' OR email='$username') AND password='$password'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];

    if($role == 'admin'){
        $_SESSION['user_id'] = $row['user_id'];
        $id = $row['user_id'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $track = "INSERT INTO login_tracking(user_id, ip_address, content, is_online) VALUES ('$id', '$ip', 'Admin Logged In','online')";
        mysqli_query($conn, $track);

        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "<script>alert('Access denied. Admins only.'); window.location.href='../../login.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid username or password.'); window.location.href='../index.php';</script>";
    exit();
}
?>
