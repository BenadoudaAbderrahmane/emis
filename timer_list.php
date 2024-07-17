<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <h2>Exam Timer</h2>

    <?php
    // Fetch all exams that are pending or waiting to happen
    $current_time = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM exams WHERE start_time > ? ORDER BY start_time";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$current_time]);
    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($exams as $exam) {
            $start_time = strtotime($exam['start_time']);
            $end_time = strtotime($exam['end_time']);
            $no_leave_start = strtotime($exam['no_leave_start']);
            $no_leave_end = strtotime($exam['no_leave_end']);

            echo "<div class='exam-container'>";
            echo "<h3>{$exam['module_name']}</h3>";
            echo "<p>Start Time: " . date('Y-m-d h:i:s A', $start_time) . "</p>";
            echo "<p>End Time: " . date('Y-m-d h:i:s A', $end_time) . "</p>";
            echo "<p>No Leave Start Time: " . date('Y-m-d h:i:s A', $no_leave_start) . "</p>";
            echo "<p>No Leave End Time: " . date('Y-m-d h:i:s A', $no_leave_end) . "</p>";
            echo "<a class='button' href='timer.php?exam_id={$exam['id']}'>View Timer</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No pending exams found.</p>";
    }
    ?>

    <div id="timer"></div>

    <script>
    const timerDiv = document.getElementById('timer');

    <?php
    if (isset($_GET['exam_id'])) {
        $exam_id = $_GET['exam_id'];
        $sql = "SELECT * FROM exams WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$exam_id]);
        $exam = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($exam) {
            echo "const exam = {";
            echo "startTime: new Date('" . $exam['start_time'] . "').getTime(),";
            echo "endTime: new Date('" . $exam['end_time'] . "').getTime(),";
            echo "noLeaveStart: new Date('" . $exam['no_leave_start'] . "').getTime(),";
            echo "noLeaveEnd: new Date('" . $exam['no_leave_end'] . "').getTime()";
            echo "};";

            // Immediately display the timer for the selected exam
            echo "updateTimer();";
        } else {
            echo "console.error('No exam found with ID: $exam_id');";
        }
    } else {
        echo "console.error('No exam ID provided in the URL');";
    }
    ?>

    function updateTimer() {
        const now = new Date().getTime();
        if (exam) {
            if (now < exam.startTime) {
                timerDiv.innerHTML = "Exam starts in " + Math.floor((exam.startTime - now) / 1000) + " seconds";
            } else if (now < exam.endTime) {
                timerDiv.innerHTML = "Exam ends in " + Math.floor((exam.endTime - now) / 1000) + " seconds";
                if (now >= exam.noLeaveStart && now <= exam.noLeaveEnd) {
                    timerDiv.innerHTML += "<br><span style='color: red;'>Students are not allowed to leave the room</span>";
                } else {
                    timerDiv.innerHTML += "<br><span style='color: green;'>Students can leave the room</span>";
                }
            } else {
                timerDiv.innerHTML = "Exam has ended";
            }
        }
    }

    setInterval(updateTimer, 1000);
    </script>
</main>
