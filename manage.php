<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <h2>Manage Exams</h2>
    <form action="manage.php" method="post">
        <label for="module_name">Module Name:</label>
        <input type="text" id="module_name" name="module_name" required>
        
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required>
        
        <label for="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required>
        
        <label for="no_leave_start">No Leave Start Time:</label>
        <input type="datetime-local" id="no_leave_start" name="no_leave_start" required>
        
        <label for="no_leave_end">No Leave End Time:</label>
        <input type="datetime-local" id="no_leave_end" name="no_leave_end" required>
        
        <label for="students_count">Number of Students Attending:</label>
        <input type="number" id="students_count" name="students_count" required>
        
        <button type="submit" name="create_exam">Create Exam</button>
    </form>

    <?php
    if (isset($_POST['create_exam'])) {
        $module_name = $_POST['module_name'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $no_leave_start = $_POST['no_leave_start'];
        $no_leave_end = $_POST['no_leave_end'];
        $number_of_students = $_POST['students_count'];

        $sql = "INSERT INTO exams (module_name, start_time, end_time, no_leave_start, no_leave_end, number_of_students) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $module_name);
        $stmt->bindValue(2, $start_time);
        $stmt->bindValue(3, $end_time);
        $stmt->bindValue(4, $no_leave_start);
        $stmt->bindValue(5, $no_leave_end);
        $stmt->bindValue(6, $number_of_students);
        
        if ($stmt->execute()) {
            echo "<p>Exam created successfully!</p>";
        } else {
            echo "<p>Error creating exam: " . $stmt->errorInfo()[2] . "</p>";
        }
    }
    ?>
</main>
<?php include 'templates/footer.php'; ?>
