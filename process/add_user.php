<?php
require '../config.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $phone  = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = md5($_POST['password']);
    $confirmpassword = md5($_POST['confirmpassword']);

    if($password === $confirmpassword) {

        // Check Email
        $checkEmail = "SELECT email FROM user_master WHERE email='$email'";
        $emailRes = mysqli_query($conn, $checkEmail);

        if(mysqli_num_rows($emailRes) > 0){
            echo "<script>alert('This email is already registered. Try logging in or use another email.'); window.location='../signup.php';</script>";
            exit();
        }

        // Check Username
        $checkUsername = "SELECT username FROM user_master WHERE username='$username'";
        $userRes = mysqli_query($conn, $checkUsername);

        if(mysqli_num_rows($userRes) > 0){
            echo "<script>alert('Username already taken. Try another one.'); window.location='../signup.php';</script>";
            exit();
        }

        // Insert New User
        $sql = "INSERT INTO user_master (name, username, phone, email, gender, password) 
                VALUES ('$name', '$username', '$phone', '$email', '$gender', '$password')";

        if(mysqli_query($conn, $sql)) {
            header("Location: ../security-questions.php");
            exit();
        } else {
            echo "Error: ".mysqli_error($conn);
        }

    } else {
        echo "<script>alert('Password and Confirm Password must be same.'); window.location='../signup.php';</script>";
        exit();
    }
}
?>