<?php
require '../config.php';

if (!isset($_SESSION['email']) || !isset($_POST['update_node'])) {
    header("Location: login.php");
    exit();
}

// 2. Data Sanitization & Extraction
$user_email = $_SESSION['email'];
$course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
$rating = mysqli_real_escape_string($conn, $_POST['rating']);
$review = mysqli_real_escape_string($conn, $_POST['review']);

// 3. Fetch User ID from Identity Node
$user_query = mysqli_query($conn, "SELECT user_id FROM user_master WHERE email = '$user_email' LIMIT 1");
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];

// 4. Integrity Check: Verify Completion Status
$check_sql = "SELECT enrollment_id FROM enrollments 
              WHERE user_id = '$user_id' 
              AND course_id = '$course_id' 
              AND status = 'completed'";
$check_res = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_res) > 0) {
    // 5. Check if feedback already exists to prevent duplicate nodes
    $duplicate_check = mysqli_query($conn, "SELECT review_id FROM course_reviews WHERE user_id = '$user_id' AND course_id = '$course_id'");
    
    if (mysqli_num_rows($duplicate_check) == 0) {
        // 6. Insert Dispatch into course_reviews
        $insert_sql = "INSERT INTO course_reviews (course_id, user_id, rating, review) 
                       VALUES ('$course_id', '$user_id', '$rating', '$review')";
        
        if (mysqli_query($conn, $insert_sql)) {
            // Redirect with success signature
            header("Location: course-details.php?id=$course_id&status=feedback_synced");
        } else {
            header("Location: dashboard.php?error=transmission_failed");
        }
    } else {
        header("Location: course-details.php?id=$course_id&status=already_submitted");
    }
} else {
    // Critical Security Breach: User attempted to review a non-validated node
    header("Location: dashboard.php?error=unauthorized_dispatch");
}
exit();
?>