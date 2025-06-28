<?php
require 'db.php';

// Cek jika ID ada di URL dan merupakan angka
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php#projects');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

// Jika proyek tidak ditemukan, redirect
if (!$project) {
    header('Location: index.php#projects');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project: <?php echo htmlspecialchars($project['title']); ?> - Rahmat Ramadhan</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Gaya ini diambil dari file project asli Anda untuk memastikan tampilan tetap sama */
        .project-hero {
            background: linear-gradient(135deg, rgba(173, 154, 118, 0.1), rgba(173, 154, 118, 0.05));
            padding: 8rem 10% 4rem;
            text-align: center;
            margin-top: 80px;
        }
        .project-title {
            font-size: 3rem;
            color: #333;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        .project-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #ad9a76;
        }
        .project-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        .project-mockup {
            max-width: 800px;
            margin: 2rem auto;
            position: relative;
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        .project-mockup img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            transform: rotateY(-5deg);
            transition: transform 0.5s ease;
        }
        .project-mockup:hover img {
            transform: rotateY(0deg);
        }
        .project-details {
            padding: 4rem 10%;
            background: #f8f9fa;
        }
        .details-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            align-items: start;
        }
        .project-description h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
            position: relative;
        }
        .project-description h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 2px;
            background: #ad9a76;
        }
        .project-description p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .project-stats {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .stat-item:not(:last-child) {
            margin-bottom: 1.5rem;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        .project-cta {
            padding: 4rem 10%;
            text-align: center;
            background: #f8f9fa;
        }
        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }
        .cta-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .cta-text {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .cta-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #ad9a76;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #ad9a76;
        }
        .cta-btn:hover {
            background: transparent;
            color: #ad9a76;
        }
        @media (max-width: 992px) {
            .details-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo">Rahmat <span>Ramadhan</span></a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <nav class="navbar">
            <a href="index.php#home">Beranda</a>
            <a href="index.php#about">Tentang</a>
            <a href="index.php#article">Artikel</a>
            <a href="index.php#projects">Proyek</a>
            <a href="index.php#contact">Kontak</a>
        </nav>
        <a href="index.php#contact" class="gradient-btn">Contact Me</a>
    </header>

    <section class="project-hero">
        <h1 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h1>
        <p class="project-subtitle"><?php echo htmlspecialchars($project['subtitle']); ?></p>
        <div class="project-mockup">
            <img src="./img/<?php echo htmlspecialchars($project['image']); ?>" alt="Mockup <?php echo htmlspecialchars($project['title']); ?>">
        </div>
    </section>

    <section class="project-details">
        <div class="details-container">
            <div class="project-info">
                <div class="project-description">
                    <h3>Tentang Project</h3>
                    <p><?php echo nl2br(htmlspecialchars($project['about_project'])); ?></p>
                </div>
            </div>
            <div class="project-stats">
                <div class="stat-item">
                    <div class="stat-label">Durasi Proyek</div>
                    <div class="stat-value"><?php echo htmlspecialchars($project['duration']); ?></div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Platform</div>
                    <div class="stat-value"><?php echo htmlspecialchars($project['platform']); ?></div>
                </div>
            </div>
        </div>
    </section>

    <section class="project-cta">
        <div class="cta-content">
            <h2 class="cta-title">Ingin melihat proyek lainnya?</h2>
            <p class="cta-text">Jelajahi portofolio saya untuk melihat proyek desain UI/UX lainnya dan studi kasus yang menunjukkan proses desain dan pendekatan pemecahan masalah saya.</p>
            <a href="index.php#projects" class="cta-btn">Lihat Semua Proyek</a>
        </div>
    </section>

    <script src="script.js"></script>
    <script>
        // Animasi 3D untuk mockup
        document.addEventListener("DOMContentLoaded", function() {
            const mockup = document.querySelector('.project-mockup');
            if (mockup) {
                mockup.addEventListener('mousemove', function(e) {
                    const rect = this.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateY = (x - centerX) / 20;
                    const rotateX = (centerY - y) / 20;
                    
                    this.querySelector('img').style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;
                });
                
                mockup.addEventListener('mouseleave', function() {
                    this.querySelector('img').style.transform = 'rotateY(-5deg)';
                });
            }
        });
    </script>
</body>
</html>