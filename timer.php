<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <h2>Exam Timer</h2>

    <?php
    // Check if exam_id is provided in the URL
    if (isset($_GET['exam_id'])) {
        $exam_id = $_GET['exam_id'];

        // Fetch the specific exam details from the database
        $sql = "SELECT * FROM exams WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$exam_id]);
        $exam = $stmt->fetch(PDO::FETCH_ASSOC);

        // If exam details are found, display the timer for that exam
        if ($exam) {
            $start_time = strtotime($exam['start_time']);
            $end_time = strtotime($exam['end_time']);
            $no_leave_start = strtotime($exam['no_leave_start']);
            $no_leave_end = strtotime($exam['no_leave_end']);

            echo "<div>";
            echo "<h3>{$exam['module_name']}</h3>";
            echo "<p>Start Time: " . date('Y-m-d h:i:s A', $start_time) . "</p>";
            echo "<p>End Time: " . date('Y-m-d h:i:s A', $end_time) . "</p>";
            echo "<p>No Leave Start Time: " . date('Y-m-d h:i:s A', $no_leave_start) . "</p>";
            echo "<p>No Leave End Time: " . date('Y-m-d h:i:s A', $no_leave_end) . "</p>";
            echo "</div>";

            // JavaScript timer setup
            echo "<div id='timer' style='display: flex; align-items: center;'>";
            echo "<div style='flex: 1;' id='timerText'></div>";
            echo "<div style='flex: 0 0 auto; margin-left: 10px;' id='timerImage'></div>";
            echo "</div>";
            echo "<script>";
            echo "const timerTextDiv = document.getElementById('timerText');";
            echo "const timerImageDiv = document.getElementById('timerImage');";
            echo "const exam = {";
            echo "startTime: new Date('" . $exam['start_time'] . "').getTime(),";
            echo "endTime: new Date('" . $exam['end_time'] . "').getTime(),";
            echo "noLeaveStart: new Date('" . $exam['no_leave_start'] . "').getTime(),";
            echo "noLeaveEnd: new Date('" . $exam['no_leave_end'] . "').getTime()";
            echo "};";

            echo "function updateTimer() {";
            echo "const now = new Date().getTime();";
            echo "if (now < exam.startTime) {";
            echo "timerTextDiv.innerHTML = 'Exam starts in ' + Math.floor((exam.startTime - now) / 1000) + ' seconds';";
            echo "} else if (now < exam.endTime) {";
            echo "timerTextDiv.innerHTML = 'Exam ends in ' + Math.floor((exam.endTime - now) / 1000) + ' seconds';";
            echo "if (now >= exam.noLeaveStart && now <= exam.noLeaveEnd) {";
            echo "timerTextDiv.innerHTML += '<br><span style=\"color: red;\">Students are not allowed to leave the room</span>';";
            echo "timerImageDiv.innerHTML = '<img src=\"images/Not_Going_Out.webp\" alt=\"No Leave Image\" style=\"max-width: 150px;\">';";
            echo "} else {";
            echo "timerTextDiv.innerHTML += '<br><span style=\"color: green;\">Students can leave the room</span>';";
            echo "timerImageDiv.innerHTML = '';"; // Clear the image if not in no-leave period
            echo "}";
            echo "} else {";
            echo "timerTextDiv.innerHTML = 'Exam has ended';";
            echo "}";
            echo "}";

            echo "setInterval(updateTimer, 1000);";
            echo "</script>";
        } else {
            // If exam_id provided does not exist in database
            echo "<p>Exam not found.</p>";
        }
    } else {
        // If exam_id is not provided in the URL
        echo "<p>No exam selected. Please select an exam to view the timer.</p>";
    }
    ?>

</main>
