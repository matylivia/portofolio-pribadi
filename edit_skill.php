<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;
$skill = null;

// Jika ada ID, ambil data skill untuk diedit
if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM skills WHERE id = ?');
    $stmt->execute([$id]);
    $skill = $stmt->fetch();
}

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $percentage = $_POST['percentage'];

    // Validasi percentage antara 0-100
    if ($percentage < 0) $percentage = 0;
    if ($percentage > 100) $percentage = 100;

    if ($id) {
        // Update skill yang ada
        $stmt = $pdo->prepare('UPDATE skills SET name = ?, percentage = ? WHERE id = ?');
        $stmt->execute([$name, $percentage, $id]);
    } else {
        // Tambah skill baru
        $stmt = $pdo->prepare('INSERT INTO skills (name, percentage) VALUES (?, ?)');
        $stmt->execute([$name, $percentage]);
    }
    
    // Redirect kembali ke dashboard
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Skill</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contact-container" style="margin-top: 50px;">
        <form method="POST" class="contact-form">
            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Skill</h2>
            
            <div class="form-group">
                <label for="name">Skill Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($skill['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="percentage">Percentage (0-100)</label>
                <input type="number" id="percentage" name="percentage" min="0" max="100" value="<?php echo htmlspecialchars($skill['percentage'] ?? '80'); ?>" required>
            </div>

            <button type="submit" class="submit-btn">Save Skill</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>