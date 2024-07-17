<?php
require_once 'includes/db.php'; // Adjust this path based on your directory structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = $_POST['exam_id'];
    $log_message = $_POST['log_message'];

    // Check if exam_id exists in exams table
    $stmt_check_exam = $conn->prepare("SELECT id FROM exams WHERE id = :exam_id");
    $stmt_check_exam->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    $stmt_check_exam->execute();

    // Fetch the result to check if the exam_id exists
    $exam_exists = $stmt_check_exam->fetch(PDO::FETCH_ASSOC);

    if ($exam_exists) {
        // Proceed with inserting the log entry
        $stmt_insert_log = $conn->prepare("INSERT INTO logs (exam_id, log_message) VALUES (:exam_id, :log_message)");
        $stmt_insert_log->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
        $stmt_insert_log->bindParam(':log_message', $log_message, PDO::PARAM_STR);

        if ($stmt_insert_log->execute()) {
            echo "Log entry added successfully.";
        } else {
            echo "Error adding log entry: " . $stmt_insert_log->errorInfo()[2];
        }

        $stmt_insert_log->closeCursor(); // Close cursor for next query
    } else {
        echo "Error: Exam ID does not exist.";
    }

    $stmt_check_exam->closeCursor(); // Close cursor after checking
} else {
    // Redirect to log_form.php if accessed directly without POST method
    header("Location: log_form.php");
    exit();
}

$conn = null; // Close connection
?>
