<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $success_count = 0;

    // Start transaction for atomic security update
    mysqli_begin_transaction($conn);

    try {
        // Clear previous answers if they exist (Resetting Security Nodes)
        mysqli_query($conn, "DELETE FROM user_security_answers WHERE user_id = '$user_id'");

        for ($i = 1; $i <= 3; $i++) {
            $q_id = mysqli_real_escape_string($conn, $_POST["q_id_$i"]);
            $answer = strtolower(trim($_POST["answer_$i"])); // Normalize to lowercase for easier recovery
            
            // Hash the answer so even DB admins can't see it
            $answer_hash = password_hash($answer, PASSWORD_BCRYPT);

            $sql = "INSERT INTO user_security_answers (user_id, question_id, answer_hash) 
                    VALUES ('$user_id', '$q_id', '$answer_hash')";
            
            if (mysqli_query($conn, $sql)) {
                $success_count++;
            }
        }

        if ($success_count === 3) {
            mysqli_commit($conn);
            header("Location: ../login.php?message=security_setup_success");
        } else {
            throw new Exception("Incomplete security mapping.");
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../security-questions.php?error=system_failure");
    }
} else {
    header("Location: ../security-questions.php?error=invalid_access");
}