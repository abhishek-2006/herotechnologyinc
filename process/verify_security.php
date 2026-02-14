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
            // Safety check for empty inputs
            if(empty($_POST["q_id_$i"]) || empty($_POST["answer_$i"])) {
                throw new Exception("EMPTY_NODE: All security markers must be filled.");
            }

            $q_id = mysqli_real_escape_string($conn, $_POST["q_id_$i"]);
            
            // Normalize to lowercase so recovery isn't case-sensitive for the student
            $answer = strtolower(trim($_POST["answer_$i"])); 
            
            // Hash the answer for 256-bit grade security
            $answer_hash = password_hash($answer, PASSWORD_BCRYPT);

            $sql = "INSERT INTO user_security_answers (user_id, question_id, answer_hash) 
                    VALUES ('$user_id', '$q_id', '$answer_hash')";
            
            if (mysqli_query($conn, $sql)) {
                $success_count++;
            }
        }

        if ($success_count === 3) {
            mysqli_commit($conn);
            // Redirect with a high-fidelity success signal
            header("Location: ../login.php?status=vault_locked");
            exit();
        } else {
            throw new Exception("INCOMPLETE_MAPPING: Success count mismatch.");
        }

    } catch (Exception $e) {
        mysqli_rollback($conn);
        // Return to vault with specific error logs
        header("Location: ../security-questions.php?error=node_failure");
        exit();
    }
} else {
    header("Location: ../security-questions.php?error=access_denied");
    exit();
}