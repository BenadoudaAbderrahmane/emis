<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update site name
    $site_name = $_POST['site_name'];
    $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = 'site_name'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$site_name]);

    // Update university logo
    if (isset($_FILES['university_logo']) && $_FILES['university_logo']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'images/';
        $upload_file = $upload_dir . basename($_FILES['university_logo']['name']);
        if (move_uploaded_file($_FILES['university_logo']['tmp_name'], $upload_file)) {
            $sql = "UPDATE settings SET setting_value = ? WHERE setting_key = 'university_logo'";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$upload_file]);
        } else {
            echo "Failed to upload logo.";
        }
    }

    // Redirect to settings form after update
    header("Location: settings_form.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
