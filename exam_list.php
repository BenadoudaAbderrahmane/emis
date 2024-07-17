<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <h2>List of Exams</h2>

    <?php
    $sql = "SELECT * FROM exams";
    $stmt = $conn->query($sql);

    if ($stmt->rowCount() > 0) {
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>
                <th>Exam ID</th>
                <th>Module Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>No Leave Start Time</th>
                <th>No Leave End Time</th>
                <th>Number of Students</th>
                <th>Actions</th>
              </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['module_name']}</td>
                    <td>{$row['start_time']}</td>
                    <td>{$row['end_time']}</td>
                    <td>{$row['no_leave_start']}</td>
                    <td>{$row['no_leave_end']}</td>
                    <td>{$row['number_of_students']}</td>
                    <td>
                        <a href='exam_details.php?id={$row['id']}'>Details</a> |
                        <a href='update_exam.php?id={$row['id']}'>Update</a> |
                        <a href='delete_exam.php?id={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No exams found.</p>";
    }

    // Close the connection
    $conn = null;
    ?>
</main>

