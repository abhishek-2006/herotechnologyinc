<?php
require '../config.php';

$email = $_POST['email'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM user_master WHERE (email='$email' OR username='$email') AND password='$password'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];

    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $row['user_id'];

    if ($role === 'student') {
        $user_id = $row['user_id'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $qry = "INSERT INTO login_tracking (user_id, ip_address, content, is_online)
        VALUES ('$user_id', '$ip', 'Student Logged In', 'online')";

        mysqli_query($conn, $qry);

        header('Location: ../dashboard.php');
        exit;
    } elseif ($role === 'manager') {
        $user_id = $row['user_id'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = "INSERT INTO login_tracking (user_id, ip_address, content, is_online)
        VALUES ('$user_id', '$ip', 'Manager Logged In', 'online')";

        mysqli_query($conn, $sql);

        header('Location: ../manager/dashboard.php');
        exit;
    } elseif ($role === 'admin') {
        $user_id = $row['user_id'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = "INSERT INTO login_tracking (user_id, ip_address, content, is_online)
        VALUES ('$user_id', '$ip', 'Admin Logged In', 'online')";

        mysqli_query($conn, $sql);
        header("Location: ../backpanel/dashboard.php");
        exit();
    }
} 
else {
    echo "<script>
            alert('Invalid email or password.');
            window.location.href='../login.php';
          </script>";
    exit;
}
?>  