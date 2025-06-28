<?php
require 'db.php';
$articles = $pdo->query("SELECT * FROM articles ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - Rahmat Ramadhan</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Gaya dasar halaman artikel, sama seperti contoh article.html Anda */
        .article-page {
            padding-top: 80px;
        }
        .articles-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .article-section {
            margin-bottom: 5rem;
            padding-bottom: 3rem;
        }
        .article-section:not(:last-child) {
            border-bottom: 1px solid #eee;
        }
        .article-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .article-number {
            font-size: 5rem;
            font-weight: 900;
            color: rgba(173, 154, 118, 0.2);
            line-height: 1;
            margin-bottom: 1rem;
        }
        .article-section-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        .article-section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #ad9a76;
        }
        .article-section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        .article-image-caption {
            text-align: center;
            font-size: 0.9em;
            color: #888;
            margin-top: 0.5rem;
        }
        .back-to-top {
            display: block;
            text-align: center;
            margin-top: 3rem;
            color: #ad9a76;
            text-decoration: none;
            font-weight: 600;
        }
        .back-to-top i {
            vertical-align: middle;
            margin-left: 5px;
        }

        /* ======================================= */
        /* CSS PENTING UNTUK ANIMASI 3D GAMBAR     */
        /* ======================================= */
        .article-text {
            /* Menerapkan perspective ke parent dari gambar */
            perspective: 1000px;
        }
        
        .article-image {
             /* Penting untuk menjaga transformasi 3D */
            transform-style: preserve-3d;
            margin: 2rem 0;
        }
        
        .article-image img {
            width: 100%;
            display: block;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            transform: rotateY(-5deg); /* Posisi awal sedikit miring */
        }
        
        .article-image:hover img {
            transform: rotateY(0deg); /* Kembali lurus saat di-hover */
        }
        /* ======================================= */
        /* AKHIR CSS PENTING                       */
        /* ======================================= */
    </style>
</head>
<body class="article-page">
    <header class="header">
        <a href="index.php" class="logo">Rahmat <span>Ramadhan</span></a>
        <i class='bx bx-menu' id="menu-icon"></i>
        <nav class="navbar">
            <a href="index.php#home">Home</a>
            <a href="index.php#about">About</a>
            <a href="index.php#article" class="active">Article</a>
            <a href="index.php#projects">Projects</a>
            <a href="index.php#contact">Contact</a>
        </nav>
        <a href="index.php#contact" class="gradient-btn">Contact Me</a>
    </header>

    <section class="articles-content" id="top">
        <div class="articles-container">
            <?php foreach ($articles as $article): ?>
            <article class="article-section" id="<?php echo htmlspecialchars($article['link_id']); ?>">
                <div class="article-header">
                    <div class="article-number"><?php echo htmlspecialchars($article['article_number']); ?></div>
                    <h2 class="article-section-title"><?php echo htmlspecialchars($article['title']); ?></h2>
                    <p class="article-section-subtitle"><?php echo htmlspecialchars($article['subtitle']); ?></p>
                </div>
                
                <div class="article-text">
                    <div class="article-image">
                        <img src="./img/<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
                        <?php if (!empty($article['main_image_caption'])): ?>
                            <p class="article-image-caption"><?php echo htmlspecialchars($article['main_image_caption']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <?php echo $article['content']; ?>

                    <?php 
                    if (!empty($article['gallery_images'])) {
                        $galleryImages = explode(',', $article['gallery_images']);
                        echo '<div class="article-gallery">';
                        foreach ($galleryImages as $img) {
                            $img = trim($img);
                            if (!empty($img)) {
                                echo '<div class="gallery-item"><img src="./img/' . htmlspecialchars($img) . '" alt="Gallery Image"></div>';
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                    
                    <a href="#top" class="back-to-top">Kembali ke atas <i class='bx bx-up-arrow-alt'></i></a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="article-cta">
        <h2>Tertarik dengan artikel saya?</h2>
        <p>Jangan ragu untuk menghubungi saya jika Anda memiliki pertanyaan atau ingin berdiskusi lebih lanjut.</p>
        <a href="index.php#contact" class="back-btn">Hubungi Saya</a>
        <a href="index.php" class="back-btn">Kembali ke Beranda</a>
    </section>

    <script src="script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Script untuk smooth scroll (tidak diubah)
      if (window.location.hash && window.location.hash !== '#top') {
          const targetId = window.location.hash;
          const targetElement = document.querySelector(targetId);
          if (targetElement) {
              setTimeout(() => {
                  window.scrollTo({
                      top: targetElement.offsetTop - 100,
                      behavior: 'smooth'
                  });
              }, 300);
          }
      }

      // Menargetkan semua div .article-image yang berisi gambar
      const imageWrappers = document.querySelectorAll('.article-image');

      imageWrappers.forEach(wrapper => {
          const image = wrapper.querySelector('img');
          if (image) {
              wrapper.addEventListener('mousemove', (e) => {
                  const rect = wrapper.getBoundingClientRect();
                  const x = e.clientX - rect.left;
                  const y = e.clientY - rect.top;
                  const centerX = rect.width / 2;
                  const centerY = rect.height / 2;
                  
                  const rotateY = (x - centerX) / 20;
                  const rotateX = (centerY - y) / 20;

                  image.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg) scale(1.02)`;
              });
              
              wrapper.addEventListener('mouseleave', () => {
                  image.style.transform = 'rotateY(-5deg) scale(1)';
              });
          }
      });
    });
    </script>
</body>
</html>