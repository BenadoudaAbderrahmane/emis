<?php
require_once __DIR__ . '/../includes/db.php';

// Fetch current settings from the database
$sql = "SELECT setting_key, setting_value FROM settings";
$stmt = $conn->query($sql);
$settings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title><?php echo htmlspecialchars($settings['site_name']); ?></title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="<?php echo htmlspecialchars($settings['university_logo']); ?>" alt="University Logo">
        </div>
        <h1><?php echo htmlspecialchars($settings['site_name']); ?></h1>
        <a class="button" href="index.php">Home</a>
    </header>

