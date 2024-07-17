<?php include 'templates/header.php'; ?>

<main>
    <h2>Update Settings</h2>
    <form action="update_settings.php" method="post" enctype="multipart/form-data">
        <label for="site_name">Site Name:</label>
        <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>

        <label for="university_logo">University Logo:</label>
        <input type="file" id="university_logo" name="university_logo" accept="image/*">

        <button type="submit">Update Settings</button>
    </form>
</main>
</body>
</html>
