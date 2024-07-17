<?php include 'templates/header.php'; ?>
    <main>
        <h2>Add Log Entry</h2>
        <form action="log.php" method="post">
            <label for="exam_id">Exam ID:</label>
            <input type="number" id="exam_id" name="exam_id" required>
            
            <label for="log_message">Log Message:</label>
            <textarea id="log_message" name="log_message" required></textarea>
            
            <button type="submit">Add Log</button>
        </form>
    </main>

</body>
</html>
