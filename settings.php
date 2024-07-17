
<?php include 'templates/header.php'; ?>
<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = $_POST['site_name'];
    $university_logo = $_POST['university_logo'];

    // Update settings in the database
    $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$site_name, 'site_name']);
    $stmt->execute([$university_logo, 'university_logo']);

    $message = "Settings updated successfully!";
}

// Fetch current settings from the database
$sql = "SELECT * FROM settings";
$stmt = $conn->query($sql);
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    <main>
        <?php if (isset($message)) { echo "<p class='success-message'>$message</p>"; } ?>
        <form action="settings.php" method="post">
            <label for="site_name">Site Name:</label>
            <input type="text" id="site_name" name="site_name" value="<?php echo $settings['site_name']; ?>" required>

            <label for="university_logo">University Logo URL:</label>
            <input type="text" id="university_logo" name="university_logo" value="<?php echo $settings['university_logo']; ?>" required>

            <button type="submit">Save Settings</button>
        </form>
    </main>
</body>
</html>
