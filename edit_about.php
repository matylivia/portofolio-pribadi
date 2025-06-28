<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$stmt = $pdo->query('SELECT * FROM about LIMIT 1');
$about = $stmt->fetch();
$id = $about['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $intro = $_POST['intro'];
    $details = $_POST['details'];
    $image = $_POST['current_image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }
    
    // Jika sudah ada data, UPDATE. Jika belum, INSERT.
    if ($id) {
        $stmt = $pdo->prepare('UPDATE about SET intro = ?, details = ?, image = ? WHERE id = ?');
        $stmt->execute([$intro, $details, $image, $id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO about (intro, details, image) VALUES (?, ?, ?)');
        $stmt->execute([$intro, $details, $image]);
    }
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit About Section</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contact-container" style="margin-top: 50px;">
        <form method="POST" enctype="multipart/form-data" class="contact-form">
            <h2>Edit About Section</h2>
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($about['image'] ?? ''); ?>">
            <div class="form-group">
                <label for="intro">Intro Text</label>
                <textarea id="intro" name="intro" rows="3" required><?php echo htmlspecialchars($about['intro'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="details">Details Text</label>
                <textarea id="details" name="details" rows="5" required><?php echo htmlspecialchars($about['details'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                 <?php if ($about && $about['image']): ?>
                    <p>Current image: <img src="../img/<?php echo htmlspecialchars($about['image']); ?>" width="100"></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="submit-btn">Save Changes</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>