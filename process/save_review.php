<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $cid = mysqli_real_escape_string($conn, $_POST['course_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Insert Review Node
    $sql = "INSERT INTO course_reviews (course_id, user_id, rating, review, status) 
            VALUES ('$cid', '$uid', '$rating', '$review', 'active')";
    
    if (mysqli_query($conn, $sql)) {
        // Update Course Average Rating
        mysqli_query($conn, "UPDATE courses SET rating = (SELECT AVG(rating) FROM course_reviews WHERE course_id = '$cid') WHERE course_id = '$cid'");
        
        header("Location: ../dashboard.php?msg=review_synced");
    } else {
        header("Location: ../learn.php?id=$cid&error=db_failure");
    }
}
?>