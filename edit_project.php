<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;
$project = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $project = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari form, termasuk 'link' yang baru
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $about_project = $_POST['about_project'];
    $duration = $_POST['duration'];
    $platform = $_POST['platform'];
    $link = $_POST['link']; // Mengambil data link dari form
    $current_image = $_POST['current_image'] ?? '';

    // Proses upload gambar baru jika ada
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    } else {
        $image = $current_image;
    }

    $params = [
        $title,
        $subtitle,
        $description,
        $about_project,
        $duration,
        $platform,
        $link, // Menambahkan link ke parameter
        $image
    ];

    if ($id) {
        // Query UPDATE sekarang menyertakan `link`
        $sql = "UPDATE projects SET title = ?, subtitle = ?, description = ?, about_project = ?, duration = ?, platform = ?, link = ?, image = ? WHERE id = ?";
        $params[] = $id;
    } else {
        // Query INSERT sekarang menyertakan `link`
        $sql = "INSERT INTO projects (title, subtitle, description, about_project, duration, platform, link, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Project</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contact-container" style="margin-top: 50px; max-width: 800px;">
        <form method="POST" enctype="multipart/form-data" class="contact-form">
            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Project</h2>
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($project['image'] ?? ''); ?>">

            <div class="form-group">
                <label for="title">Judul Utama (e.g., Aplikasi Mobile)</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="subtitle">Subtitle (Teks di bawah judul utama)</label>
                <input type="text" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($project['subtitle'] ?? ''); ?>" required>
            </div>
             <div class="form-group">
                <label for="description">Deskripsi Singkat (Untuk di halaman utama)</label>
                <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($project['description'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Gambar Proyek</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($id && !empty($project['image'])): ?>
                    <p>Current: <img src="../img/<?php echo htmlspecialchars($project['image']); ?>" width="100"></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="about_project">Tentang Project (Deskripsi lengkap)</label>
                <textarea id="about_project" name="about_project" rows="6" required><?php echo htmlspecialchars($project['about_project'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="duration">Durasi Proyek</label>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($project['duration'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" id="platform" name="platform" value="<?php echo htmlspecialchars($project['platform'] ?? ''); ?>" required>
            </div>
             <div class="form-group">
                <label for="link">Link Tombol "View Project" (e.g., project.php?id=1)</label>
                <input type="text" id="link" name="link" value="<?php echo htmlspecialchars($project['link'] ?? ''); ?>" required>
            </div>
            
            <button type="submit" class="submit-btn">Save Project</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>