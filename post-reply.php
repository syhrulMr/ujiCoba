<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "Anda harus login terlebih dahulu!";
  exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['topic_id']) && isset($_POST['parent_id']) && isset($_POST['reply_content'])) {
  $topic_id = $_POST['topic_id'];
  $parent_id = $_POST['parent_id'];
  $reply_content = $_POST['reply_content'];
  $user_id = $_SESSION['user_id']; // Gunakan ID pengguna yang sedang login

  if (empty($reply_content)) {
    echo "Isi balasan tidak boleh kosong!";
    exit;
  }

  $query = "INSERT INTO comments (topic_id, parent_id, user_id, content, created_at)
              VALUES (:topic_id, :parent_id, :user_id, :content, NOW())";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':topic_id', $topic_id);
  $stmt->bindParam(':parent_id', $parent_id);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':content', $reply_content);

  if ($stmt->execute()) {
    header("Location: topic-detail.php?id=" . $topic_id);
    exit;
  } else {
    echo "Gagal menyimpan balasan.";
  }
} else {
  echo "Data tidak lengkap!";
}
