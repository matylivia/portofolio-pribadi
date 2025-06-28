<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;

// Jika ada ID, hapus data dari database
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM skills WHERE id = ?');
    $stmt->execute([$id]);
}

// Redirect kembali ke dashboard
header('Location: dashboard.php');
exit;
?>