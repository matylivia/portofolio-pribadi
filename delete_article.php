<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
require '../db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Optional: Hapus file gambar dari server
    // $stmt = $pdo->prepare('SELECT image FROM articles WHERE id = ?');
    // $stmt->execute([$id]);
    // $image = $stmt->fetchColumn();
    // if ($image && file_exists('../img/' . $image)) {
    //     unlink('../img/' . $image);
    // }

    $stmt = $pdo->prepare('DELETE FROM articles WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit;
?>