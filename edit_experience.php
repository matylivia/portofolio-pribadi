<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;
$experience = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM experience WHERE id = ?');
    $stmt->execute([$id]);
    $experience = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($id) {
        $stmt = $pdo->prepare('UPDATE experience SET date = ?, title = ?, description = ? WHERE id = ?');
        $stmt->execute([$date, $title, $description, $id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO experience (date, title, description) VALUES (?, ?, ?)');
        $stmt->execute([$date, $title, $description]);
    }
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Experience</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contact-container" style="margin-top: 50px;">
        <form method="POST" class="contact-form">
            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Experience</h2>
            <div class="form-group">
                <label for="date">Date (e.g., 2023 - Present)</label>
                <input type="text" id="date" name="date" value="<?php echo htmlspecialchars($experience['date'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="title">Title (e.g., UI/UX Designer)</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($experience['title'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($experience['description'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="submit-btn">Save Experience</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>