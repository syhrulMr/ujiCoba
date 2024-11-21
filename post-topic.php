<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "Anda harus login terlebih dahulu!";
  exit;
}

include 'db.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Ambil data dari form
  $title = $_POST['title'];
  $category_id = $_POST['category'];
  $content = $_POST['content'];
  $user_id = $_SESSION['user_id']; // Mengambil ID pengguna dari sesi login

  // Validasi data sederhana
  if (empty($title) || empty($category_id) || empty($content)) {
    echo "Semua bidang wajib diisi!";
    exit;
  }

  // Query untuk menyimpan topik baru ke database
  $query = "INSERT INTO topics (user_id, category_id, title, content, created_at)
              VALUES (:user_id, :category_id, :title, :content, NOW())";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':category_id', $category_id);
  $stmt->bindParam(':title', $title);
  $stmt->bindParam(':content', $content);

  if ($stmt->execute()) {
    // Redirect ke halaman utama atau halaman topik setelah berhasil
    header("Location: index.php");
    exit;
  } else {
    echo "Gagal menyimpan topik.";
  }
} else {
  echo "Invalid request method.";
}
