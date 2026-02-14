<?php
require '../config.php';

$username = isset($_GET['username']) ? mysqli_real_escape_string($conn, trim($_GET['username'])) : '';

$response = ['available' => false, 'message' => ''];

if (strlen($username) < 3) {
    $response['message'] = 'Minimum 3 characters required';
} else {
    $query = "SELECT username FROM user_master WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $response['available'] = false;
        $response['message'] = 'Username is already taken';
    } else {
        $response['available'] = true;
        $response['message'] = 'Username is available';
    }
}

header('Content-Type: application/json');
echo json_encode($response);