
<?php include 'templates/header.php'; ?>
<?php
require_once 'includes/db.php'; // Adjust this path based on your directory structure

// Prepare and execute SQL statement to select all logs
$stmt = $conn->prepare("SELECT * FROM logs ORDER BY created_at DESC");
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <main>
        <h2>All Log Entries</h2>
        <?php if ($logs): ?>
            <ul>
                <?php foreach ($logs as $log): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($log['created_at']); ?>:</strong>
                        <?php echo htmlspecialchars($log['log_message']); ?>
                        (Exam ID: <?php echo htmlspecialchars($log['exam_id']); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No log entries found.</p>
        <?php endif; ?>
    </main>


    <?php
    $stmt->closeCursor(); // Close cursor after using it
    $conn = null; // Close connection
    ?>
</body>
</html>
