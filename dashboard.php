<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

// Ambil semua data yang akan ditampilkan di dasbor
$about = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$skills = $pdo->query("SELECT * FROM skills ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$experiences = $pdo->query("SELECT * FROM experience ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$activities = $pdo->query("SELECT * FROM activity ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$articles = $pdo->query("SELECT * FROM articles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { padding: 100px 20px; max-width: 1200px; margin: auto; }
        .admin-section { background: #f4f4f4; padding: 20px; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .admin-section h2 { margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        .admin-table th, .admin-table td { padding: 12px; border: 1px solid #ddd; text-align: left; vertical-align: middle; }
        .admin-table th { background-color: #e9ecef; }
        .admin-table img { max-width: 100px; height: auto; border-radius: 5px; }
        .admin-table .actions a { margin-right: 10px; color: #ad9a76; text-decoration: none; font-weight: bold; }
        .admin-table .actions a.delete { color: #e74c3c; }
        .btn-add { display: inline-block; padding: 10px 15px; background: #ad9a76; color: white !important; text-decoration: none; border-radius: 5px; margin-bottom: 20px; font-weight: normal; }
        .btn-add:hover { background: #9a792a; }
    </style>
</head>
<body>
    <header class="header">
        <a href="dashboard.php" class="logo">Admin <span>Panel</span></a>
        <nav class="navbar">
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="admin-container">
        <h1>Welcome, Admin!</h1>

        <div class="admin-section">
            <h2>About Section</h2>
            <a href="edit_about.php" class="btn-add">Edit About Section</a>
        </div>

        <div class="admin-section">
            <h2>Skills</h2>
            <a href="edit_skill.php" class="btn-add">Add New Skill</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Skill Name</th>
                        <th>Percentage</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($skill['name']); ?></td>
                        <td><?php echo htmlspecialchars($skill['percentage']); ?>%</td>
                        <td class="actions">
                            <a href="edit_skill.php?id=<?php echo $skill['id']; ?>">Edit</a>
                            <a href="delete_skill.php?id=<?php echo $skill['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus skill ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>Experience</h2>
            <a href="edit_experience.php" class="btn-add">Add New Experience</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Date</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($experiences as $exp): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exp['date']); ?></td>
                        <td><?php echo htmlspecialchars($exp['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($exp['description'], 0, 100)); ?>...</td>
                        <td class="actions">
                            <a href="edit_experience.php?id=<?php echo $exp['id']; ?>">Edit</a>
                            <a href="delete_experience.php?id=<?php echo $exp['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus experience ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>Activity</h2>
            <a href="edit_activity.php" class="btn-add">Add New Activity</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 15%;">Date</th>
                        <th>Title</th>
                        <th>Place/Event</th>
                        <th>Description</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $act): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($act['date']); ?></td>
                        <td><?php echo htmlspecialchars($act['title']); ?></td>
                        <td><?php echo htmlspecialchars($act['place']); ?></td>
                        <td><?php echo htmlspecialchars(substr($act['description'], 0, 80)); ?>...</td>
                        <td class="actions">
                            <a href="edit_activity.php?id=<?php echo $act['id']; ?>">Edit</a>
                            <a href="delete_activity.php?id=<?php echo $act['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus activity ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>Articles</h2>
            <a href="edit_article.php" class="btn-add">Add New Article</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><img src="../img/<?php echo htmlspecialchars($article['image']); ?>" alt=""></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars($article['subtitle']); ?></td>
                        <td class="actions">
                            <a href="edit_article.php?id=<?php echo $article['id']; ?>">Edit</a>
                            <a href="delete_article.php?id=<?php echo $article['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>Projects</h2>
            <a href="edit_project.php" class="btn-add">Add New Project</a>
             <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><img src="../img/<?php echo htmlspecialchars($project['image']); ?>" alt=""></td>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($project['description'], 0, 100)); ?>...</td>
                        <td class="actions">
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>">Edit</a>
                            <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="delete" onclick="return confirm('Yakin ingin menghapus proyek ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>