<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;
$activity = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM activity WHERE id = ?');
    $stmt->execute([$id]);
    $activity = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $place = $_POST['place'];
    $description = $_POST['description'];

    if ($id) {
        $stmt = $pdo->prepare('UPDATE activity SET date = ?, title = ?, place = ?, description = ? WHERE id = ?');
        $stmt->execute([$date, $title, $place, $description, $id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO activity (date, title, place, description) VALUES (?, ?, ?, ?)');
        $stmt->execute([$date, $title, $place, $description]);
    }
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Activity</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contact-container" style="margin-top: 50px;">
        <form method="POST" class="contact-form">
            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Activity</h2>
            <div class="form-group">
                <label for="date">Date (e.g., 2023)</label>
                <input type="text" id="date" name="date" value="<?php echo htmlspecialchars($activity['date'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="title">Title (e.g., Design Conference Speaker)</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($activity['title'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="place">Place / Event (e.g., UX Indonesia Summit)</label>
                <input type="text" id="place" name="place" value="<?php echo htmlspecialchars($activity['place'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($activity['description'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="submit-btn">Save Activity</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>