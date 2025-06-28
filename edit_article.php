<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;
$article = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = ?');
    $stmt->execute([$id]);
    $article = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $link_id = $_POST['link_id'];
    $article_number = $_POST['article_number'];
    $content = $_POST['content'];
    $main_image_caption = $_POST['main_image_caption'];
    $gallery_images = $_POST['gallery_images']; // Ambil string gambar galeri
    $current_image = $_POST['current_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    } else {
        $image = $current_image;
    }

    if ($id) {
        $sql = "UPDATE articles SET title = ?, subtitle = ?, link_id = ?, article_number = ?, content = ?, image = ?, main_image_caption = ?, gallery_images = ? WHERE id = ?";
        $params = [$title, $subtitle, $link_id, $article_number, $content, $image, $main_image_caption, $gallery_images, $id];
    } else {
        $sql = "INSERT INTO articles (title, subtitle, link_id, article_number, content, image, main_image_caption, gallery_images) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$title, $subtitle, $link_id, $article_number, $content, $image, $main_image_caption, $gallery_images];
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
    <title><?php echo $id ? 'Edit' : 'Add'; ?> Article</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .form-hint { font-size: 0.9rem; color: #666; margin-top: 5px; }
        textarea#content { min-height: 250px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="contact-container" style="margin-top: 50px; max-width: 800px;">
        <form method="POST" enctype="multipart/form-data" class="contact-form">
            <h2><?php echo $id ? 'Edit' : 'Add'; ?> Article</h2>
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($article['image'] ?? ''); ?>">
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($article['subtitle'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="article_number">Article Number (e.g., 01, 02)</label>
                <input type="text" id="article_number" name="article_number" value="<?php echo htmlspecialchars($article['article_number'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="link_id">Link ID (untuk url, tanpa spasi, e.g., prinsip-dasar-ui)</label>
                <input type="text" id="link_id" name="link_id" value="<?php echo htmlspecialchars($article['link_id'] ?? ''); ?>" required>
            </div>
             <div class="form-group">
                <label for="image">Main Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($id && !empty($article['image'])): ?>
                    <p class="form-hint">Current: <img src="../img/<?php echo htmlspecialchars($article['image']); ?>" width="100"></p>
                <?php endif; ?>
            </div>
             <div class="form-group">
                <label for="main_image_caption">Main Image Caption</label>
                <input type="text" id="main_image_caption" name="main_image_caption" value="<?php echo htmlspecialchars($article['main_image_caption'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="content">Content (Bisa menggunakan tag HTML seperti &lt;h3&gt; dan &lt;p&gt;)</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($article['content'] ?? ''); ?></textarea>
            </div>
             <div class="form-group">
                <label for="gallery_images">Gallery Images</label>
                <input type="text" id="gallery_images" name="gallery_images" value="<?php echo htmlspecialchars($article['gallery_images'] ?? ''); ?>">
                <p class="form-hint">Tulis nama file gambar, pisahkan dengan koma. Contoh: galeri1.jpg, galeri2.png, galeri3.jpg</p>
            </div>
            
            <button type="submit" class="submit-btn">Save Article</button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 20px;">Cancel</a>
        </form>
    </div>
</body>
</html>