<?php
// Menghubungkan ke database
include 'db.php';
session_start();

// Memeriksa apakah ada ID topik di URL
if (isset($_GET['id'])) {
  $topic_id = $_GET['id'];

  // Query untuk mengambil detail topik
  $query = "SELECT topics.title, topics.content, topics.created_at, users.username, categories.name AS category
              FROM topics
              JOIN users ON topics.user_id = users.id
              JOIN categories ON topics.category_id = categories.id
              WHERE topics.id = :topic_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':topic_id', $topic_id);
  $stmt->execute();
  $topic = $stmt->fetch();

  // Jika topik tidak ditemukan, tampilkan pesan
  if (!$topic) {
    echo "Topik tidak ditemukan!";
    exit;
  }

  // Query untuk mengambil komentar utama pada topik ini (dengan komentar terbaru di atas)
  $comment_query = "SELECT comments.id, comments.content, comments.created_at, users.username
                      FROM comments
                      JOIN users ON comments.user_id = users.id
                      WHERE comments.topic_id = :topic_id AND comments.parent_id IS NULL
                      ORDER BY comments.created_at DESC";
  $comment_stmt = $pdo->prepare($comment_query);
  $comment_stmt->bindParam(':topic_id', $topic_id);
  $comment_stmt->execute();
  $comments = $comment_stmt->fetchAll();
} else {
  echo "ID topik tidak ditemukan!";
  exit;
}

// Fungsi untuk mendapatkan balasan dari komentar
function getReplies($pdo, $comment_id)
{
  $reply_query = "SELECT comments.content, comments.created_at, users.username
                    FROM comments
                    JOIN users ON comments.user_id = users.id
                    WHERE comments.parent_id = :comment_id
                    ORDER BY comments.created_at ASC";
  $reply_stmt = $pdo->prepare($reply_query);
  $reply_stmt->bindParam(':comment_id', $comment_id);
  $reply_stmt->execute();
  return $reply_stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Topik</title>
  <link rel="stylesheet" href="css/gayaDpn.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Forum Apa Saja?</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Kategori
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profil</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['username'])): ?>
            <li class="nav-item">
              <span class="nav-link">Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a href="login.php" class="btn btn-success btn-sm me-2">Login</a>
            </li>
            <li class="nav-item">
              <a href="register.php" class="btn btn-success btn-sm">Daftar</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Utama -->
  <main>
    <section class="topic-detail">
      <h2><?php echo htmlspecialchars($topic['title']); ?></h2>
      <p><?php echo htmlspecialchars($topic['content']); ?></p>
      <span>oleh <?php echo htmlspecialchars($topic['username']); ?> - <?php echo $topic['created_at']; ?></span>
      <p>Kategori: <?php echo htmlspecialchars($topic['category']); ?></p>

      <!-- Komentar -->
      <div class="comments">
        <h3>Komentar</h3>
        <?php foreach ($comments as $comment): ?>
          <div class="comment">
            <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo htmlspecialchars($comment['content']); ?></p>
            <span><?php echo $comment['created_at']; ?></span>

            <!-- Menampilkan Balasan -->
            <?php
            $replies = getReplies($pdo, $comment['id']);
            foreach ($replies as $reply):
            ?>
              <div class="reply">
                <p><strong><?php echo htmlspecialchars($reply['username']); ?>:</strong> <?php echo htmlspecialchars($reply['content']); ?></p>
                <span><?php echo $reply['created_at']; ?></span>
              </div>
            <?php endforeach; ?>

            <!-- Tombol Balas Komentar -->
            <?php if (isset($_SESSION['user_id'])): ?>
              <button onclick="toggleReplyForm(<?php echo $comment['id']; ?>)">Balas Komentar</button>

              <!-- Formulir Balas Komentar -->
              <form action="post-reply.php" method="POST" class="reply-form" id="reply-form-<?php echo $comment['id']; ?>" style="display: none;">
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
                <textarea name="reply_content" rows="2" required placeholder="Balas komentar ini"></textarea>
                <button type="submit">Balas</button>
              </form>
            <?php else: ?>
              <button class="btn btn-warning" onclick="showLoginWarning()">Balas Komentar</button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>

<!-- Pesan Peringatan -->
<div id="login-warning" class="alert alert-danger mt-3" role="alert" style="display: none;">
  Anda harus login terlebih dahulu untuk menambahkan atau membalas komentar!
</div>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Tombol Tambahkan Komentar -->
          <button onclick="toggleMainCommentForm()">Tambahkan Komentar</button>

          <!-- Formulir Tambah Komentar Utama -->
          <form action="post-comment.php" method="POST" id="main-comment-form" style="display: none;">
            <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
            <label for="comment">Tambahkan Komentar</label>
            <textarea id="comment" name="comment" rows="3" required></textarea>
            <button type="submit">Kirim Komentar</button>
          </form>
        <?php else: ?>
          <!-- Jika belum login, tombol menampilkan pesan peringatan -->
          <button class="btn btn-warning" onclick="showLoginWarning()">Tambahkan Komentar</button>
        <?php endif; ?>

    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Forum Diskusi. All rights reserved.</p>
  </footer>

  <!-- JavaScript untuk mengontrol tampilan form -->
  <script>
    // Fungsi untuk menampilkan atau menyembunyikan formulir balasan berdasarkan ID komentar
    function toggleReplyForm(commentId) {
      const replyForm = document.getElementById(`reply-form-${commentId}`);
      replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
    }

    // Fungsi untuk menampilkan atau menyembunyikan formulir komentar utama
    function toggleMainCommentForm() {
      const mainCommentForm = document.getElementById('main-comment-form');
      mainCommentForm.style.display = mainCommentForm.style.display === 'none' ? 'block' : 'none';
    }

    function showLoginWarning() {
  const warning = document.getElementById('login-warning');
  warning.style.display = 'block';
  setTimeout(() => {
    warning.style.display = 'none';
  }, 3000); // Pesan akan hilang setelah 3 detik
}

  </script>
</body>

</html>