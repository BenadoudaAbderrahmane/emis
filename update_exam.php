<?php include 'templates/header.php'; ?>
<?php require_once 'includes/db.php'; ?>

<main>
    <h2>Update Exam</h2>

    <?php
    if (isset($_GET['id'])) {
        $exam_id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $module_name = $_POST['module_name'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $no_leave_start = $_POST['no_leave_start'];
            $no_leave_end = $_POST['no_leave_end'];
            $number_of_students = $_POST['number_of_students'];

            $sql = "UPDATE exams SET module_name = ?, start_time = ?, end_time = ?, no_leave_start = ?, no_leave_end = ?, number_of_students = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error);
            }

            $bind = $stmt->execute([$module_name, $start_time, $end_time, $no_leave_start, $no_leave_end, $number_of_students, $exam_id]);
            
            if ($bind === false) {
                die('Execute failed: ' . $stmt->error);
            }

            echo "<p>Exam updated successfully!</p>";
        } else {
            $sql = "SELECT * FROM exams WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error);
            }

            $bind = $stmt->execute([$exam_id]);
            
            if ($bind === false) {
                die('Execute failed: ' . $stmt->error);
            }

            $exam = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($exam) {
                ?>

                <form action="update_exam.php?id=<?php echo $exam_id; ?>" method="post">
                    <label for="module_name">Module Name:</label>
                    <input type="text" id="module_name" name="module_name" value="<?php echo htmlspecialchars($exam['module_name']); ?>" required>

                    <label for="start_time">Start Time:</label>
                    <input type="datetime-local" id="start_time" name="start_time" value="<?php echo htmlspecialchars($exam['start_time']); ?>" required>

                    <label for="end_time">End Time:</label>
                    <input type="datetime-local" id="end_time" name="end_time" value="<?php echo htmlspecialchars($exam['end_time']); ?>" required>

                    <label for="no_leave_start">No Leave Start Time:</label>
                    <input type="datetime-local" id="no_leave_start" name="no_leave_start" value="<?php echo htmlspecialchars($exam['no_leave_start']); ?>" required>

                    <label for="no_leave_end">No Leave End Time:</label>
                    <input type="datetime-local" id="no_leave_end" name="no_leave_end" value="<?php echo htmlspecialchars($exam['no_leave_end']); ?>" required>

                    <label for="number_of_students">Number of Students:</label>
                    <input type="number" id="number_of_students" name="number_of_students" value="<?php echo htmlspecialchars($exam['number_of_students']); ?>" required>

                    <button type="submit">Update Exam</button>
                </form>

                <?php
            } else {
                echo "<p>No exam found with this ID.</p>";
            }
        }
    } else {
        echo "<p>Invalid request.</p>";
    }
    ?>
</main>

