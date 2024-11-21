<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "Anda harus login terlebih dahulu!";
  exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $topic_id = $_POST['topic_id'];
  $comment_content = $_POST['comment'];
  $user_id = $_SESSION['user_id']; // Ambil ID pengguna dari session

  if (empty($comment_content)) {
    echo "Komentar tidak boleh kosong!";
    exit;
  }

  $query = "INSERT INTO comments (topic_id, user_id, content, created_at)
              VALUES (:topic_id, :user_id, :content, NOW())";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':topic_id', $topic_id);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':content', $comment_content);

  if ($stmt->execute()) {
    header("Location: topic-detail.php?id=" . $topic_id);
    exit;
  } else {
    echo "Gagal menambahkan komentar.";
  }
} else {
  echo "Invalid request method.";
}
