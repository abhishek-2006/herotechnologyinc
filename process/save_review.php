<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $cid = mysqli_real_escape_string($conn, $_POST['course_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    $duplicate_check = mysqli_query($conn, "SELECT review_id FROM course_reviews WHERE user_id = '$uid' AND course_id = '$cid' LIMIT 1");
    
    if (mysqli_num_rows($duplicate_check) > 0) {
        header("Location: ../dashboard.php?error=already_submitted");
        exit();
    }

    $sql = "INSERT INTO course_reviews (course_id, user_id, rating, review) 
            VALUES ('$cid', '$uid', '$rating', '$review')";
    
    if (mysqli_query($conn, $sql)) {
        
        mysqli_query($conn, "UPDATE enrollments SET status = 'completed' WHERE user_id = '$uid' AND course_id = '$cid'");
        mysqli_query($conn, "UPDATE courses SET rating = (SELECT AVG(rating) FROM course_reviews WHERE course_id = '$cid') WHERE course_id = '$cid'");
        
        header("Location: ../dashboard.php?msg=review_submitted");
    } else {
        header("Location: ../learn.php?id=$cid&error=db_failure");
    }
}
?>