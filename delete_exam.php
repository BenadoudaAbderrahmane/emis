<?php
require_once 'includes/db.php'; // Database connection

if (isset($_GET['id'])) {
    $exam_id = $_GET['id'];

    // Begin a transaction to ensure atomic operations
    try {
        $conn->beginTransaction();

        // Delete logs associated with the exam_id
        $delete_logs_sql = "DELETE FROM logs WHERE exam_id = :exam_id";
        $stmt_logs = $conn->prepare($delete_logs_sql);
        $stmt_logs->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
        $stmt_logs->execute();

        // Delete the exam record
        $delete_exam_sql = "DELETE FROM exams WHERE id = :exam_id";
        $stmt_exam = $conn->prepare($delete_exam_sql);
        $stmt_exam->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
        $stmt_exam->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect to exam list page after deletion
        header("Location: exam_list.php");
        exit;
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $conn->rollback();
        die('Error deleting exam: ' . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
