<?php include 'templates/header.php'; ?>
<?php require_once 'includes/db.php'; ?>

<main>
    <h2>Exam Details</h2>

    <?php
    if (isset($_GET['id'])) {
        $exam_id = $_GET['id'];

        $sql = "SELECT * FROM exams WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->execute([$exam_id]);
        $exam = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exam) {
            echo "<p>Module Name: " . htmlspecialchars($exam['module_name']) . "</p>";
            echo "<p>Start Time: " . htmlspecialchars($exam['start_time']) . "</p>";
            echo "<p>End Time: " . htmlspecialchars($exam['end_time']) . "</p>";
            echo "<p>No Leave Start Time: " . htmlspecialchars($exam['no_leave_start']) . "</p>";
            echo "<p>No Leave End Time: " . htmlspecialchars($exam['no_leave_end']) . "</p>";
            echo "<p>Number of Students: " . htmlspecialchars($exam['number_of_students']) . "</p>";
        } else {
            echo "<p>No exam found with this ID.</p>";
        }

    } else {
        echo "<p>Invalid request.</p>";
    }
    ?>
</main>
