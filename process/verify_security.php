<?php
require '../config.php';

$is_recovery = isset($_SESSION['recovery_user_id']);
$user_id = $is_recovery ? $_SESSION['recovery_user_id'] : ($_SESSION['user_id'] ?? null);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    
    // --- MODE: RECOVERY CHALLENGE ---
    if (isset($_POST['verify_recovery'])) {
        $correct_count = 0;
        for ($i = 1; $i <= 3; $i++) {
            $q_id = mysqli_real_escape_string($conn, $_POST["q_id_$i"]);
            $hashed_answer = md5(strtolower(trim($_POST["answer_$i"]))); // MD5 Verification

            $res = mysqli_query($conn, "SELECT * FROM user_security_answers WHERE user_id = '$user_id' AND question_id = '$q_id' AND answer_hash = '$hashed_answer'");
            if (mysqli_num_rows($res) > 0) $correct_count++;
        }

        if ($correct_count >= 3) {
            header("Location: ../forgot-password.php?step=reset"); // Pass to final reset form
            exit();
        } else {
            header("Location: ../security-questions.php?error=auth_failed");
            exit();
        }
    }

    // --- MODE: INITIAL SETUP ---
    if (isset($_POST['setup_vault'])) {
        mysqli_begin_transaction($conn);
        try {
            mysqli_query($conn, "DELETE FROM user_security_answers WHERE user_id = '$user_id'");
            for ($i = 1; $i <= 3; $i++) {
                $q_id = mysqli_real_escape_string($conn, $_POST["q_id_$i"]);
                $hashed_answer = md5(strtolower(trim($_POST["answer_$i"]))); // MD5 Storage
                mysqli_query($conn, "INSERT INTO user_security_answers (user_id, question_id, answer_hash) VALUES ('$user_id', '$q_id', '$hashed_answer')");
            }
            mysqli_commit($conn);
            header("Location: ../login.php?status=vault_locked");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            header("Location: ../security-questions.php?error=setup_failed");
            exit();
        }
    }
}