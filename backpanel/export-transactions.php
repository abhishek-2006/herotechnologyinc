<?php
require '../config.php';

// 1. Security Check: Admin Access Only
if (!isset($_SESSION['user_id']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')) {
    exit("Access Denied.");
}

// 2. Intelligence Gathering: Fetch all successful transactions
$query = "
    SELECT p.payment_id, u.name as student_name, c.title as course_title, 
           p.amount, p.payment_date, p.payment_method, p.payment_status 
    FROM payments p
    JOIN user_master u ON p.user_id = u.user_id
    JOIN courses c ON p.course_id = c.course_id
    ORDER BY p.payment_date DESC
";
$result = mysqli_query($conn, $query);

// 3. Header Synchronization: Tell the browser to download a CSV file
$filename = "HeroTech_Revenue_Audit_" . date('Y-m-d_H-i') . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// 4. Output Stream: Write the CSV content
$output = fopen('php://output', 'w');

// Set CSV Headers
fputcsv($output, array('Reference ID', 'Student Name', 'Course Title', 'Amount (INR)', 'Date', 'Method', 'Status'));

// Fetch and append data nodes
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, array(
            '#TXN-' . $row['payment_id'],
            $row['student_name'],
            $row['course_title'],
            $row['amount'],
            date('d M Y | H:i', strtotime($row['payment_date'])),
            strtoupper($row['payment_method']),
            strtoupper($row['payment_status'])
        ));
    }
}

fclose($output);
exit();
?>