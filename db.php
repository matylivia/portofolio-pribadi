<?php
// Pengaturan untuk koneksi database
$host = 'localhost';      // Server database, biasanya 'localhost'
$dbname = 'portofolio_db'; // Nama database yang sudah Anda buat
$username = 'root';       // Username database Anda
$password = '';           // Password database Anda, kosongkan jika tidak ada

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Mengatur mode error PDO ke exception untuk penanganan error yang lebih baik
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Mengatur fetch mode default ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan skrip dan tampilkan pesan error
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>

