<?php
require '../config.php';

// 1. Authentication Check: Ensure Identity is verified
if (!isset($_SESSION['user_id'])) {
    // Save the intended course ID to redirect back after login
    $redirect_id = isset($_GET['id']) ? $_GET['id'] : '';
    header("Location: ../login.php?redirect=enroll&id=" . $redirect_id);
    exit();
}

if (isset($_GET['id'])) {
    $course_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // 2. Intelligence Check: Is the student already authorized for this node?
    $check_query = "SELECT enrollment_id FROM enrollments 
                    WHERE user_id = '$user_id' 
                    AND course_id = '$course_id' 
                    AND status = 'active'";
    $check_res = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_res) > 0) {
        // User already has active access to this curriculum
        header("Location: ../dashboard.php?msg=already_active");
        exit();
    } else {
        // 3. Handover to Checkout Node
        // We do NOT insert data here yet; create_order.php will handle the pending entry.
        header("Location: checkout.php?id=" . $course_id);
        exit();
    }
} else {
    header("Location: ../courses.php");
    exit();
}
?>