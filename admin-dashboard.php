<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: index.php');
    exit;
}

// Ambil semua topik
$stmt = $pdo->query("SELECT topics.id, topics.title FROM topics");
$topics = $stmt->fetchAll();

// Hapus topik jika ada permintaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topicId = $_POST['topic_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM topics WHERE id = :id");
    $deleteStmt->bindParam(':id', $topicId);
    $deleteStmt->execute();
    header('Location: admin-dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Tombol Logout dan Kembali ke Halaman Utama -->
    <div class="d-flex justify-content-between my-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <h1>Dashboard Admin</h1>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Judul Topik</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($topics as $topic): ?>
          <tr>
            <td><?php echo $topic['id']; ?></td>
            <td><?php echo htmlspecialchars($topic['title']); ?></td>
            <td>
              <form action="admin-dashboard.php" method="POST" style="display:inline;">
                <input type="hidden" name="topic_id" value="<?php echo $topic['id']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
