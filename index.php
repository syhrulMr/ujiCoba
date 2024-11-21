<?php
// Menghubungkan ke database
include 'db.php';
session_start();

// Mendapatkan kategori dari URL jika ada
$categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

// Query untuk mengambil data topik berdasarkan kategori (jika ada)
$query = "SELECT topics.id, topics.title, topics.created_at, users.username, categories.name AS category
          FROM topics
          JOIN users ON topics.user_id = users.id
          JOIN categories ON topics.category_id = categories.id";

// Filter berdasarkan kategori jika category_id tersedia
if ($categoryId) {
  $query .= " WHERE categories.id = :category_id";
}

$query .= " ORDER BY topics.created_at DESC";

$stmt = $pdo->prepare($query);

if ($categoryId) {
  $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
}

$stmt->execute();
$topics = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forum Diskusi</title>
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
              <li><a class="dropdown-item" href="index.php">Semua Kategori</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=1">Teknologi</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=2">Sains</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=3">Musik</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=4">Olahraga</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=5">Film</a></li>
              <li><a class="dropdown-item" href="index.php?category_id=6">curhat</a></li>
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
              <button class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#adminModal">Admin</button>
            </li>
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

  <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalLabel">Login Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="admin-login.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
            <label for="adminPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="adminPassword" name="admin_password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>



  <!-- Main Content -->
  <main>
    <section class="topics">
      <h2>
        <?php
        if ($categoryId) {
          // Periksa apakah ada data dalam $topics
          if (!empty($topics)) {
            echo "Topik dalam Kategori: " . htmlspecialchars($topics[0]['category']);
          } else {
            echo "Tidak ada topik dalam kategori ini.";
          }
        } else {
          echo "Topik Terbaru";
        }
        ?>
      </h2>
      <div class="topic-list">
        <?php if (!empty($topics)): ?>
          <?php foreach ($topics as $topic): ?>
            <div class="topic-item">
              <h3><a href="topic-detail.php?id=<?php echo $topic['id']; ?>"><?php echo htmlspecialchars($topic['title']); ?></a></h3>
              <p>Kategori: <?php echo htmlspecialchars($topic['category']); ?></p>
              <span>oleh <?php echo htmlspecialchars($topic['username']); ?> - <?php echo $topic['created_at']; ?></span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Tidak ada topik dalam kategori ini.</p>
        <?php endif; ?>
      </div>
    </section>



    <?php if (isset($_SESSION['user_id'])): ?>
      <button class="btn btn-primary" onclick="toggleAddTopicForm()">Tambahkan Topik Baru</button>

      <!-- Form Tambah Topik -->
      <form action="post-topic.php" method="POST" id="add-topic-form" style="display: none;">
        <label for="title">Judul Topik</label>
        <input type="text" id="title" name="title" required>

        <label for="category">Kategori</label>
        <select id="category" name="category" required>
          <option value="1">Teknologi</option>
          <option value="2">Sains</option>
          <option value="3">Musik</option>
          <option value="4">Olahraga</option>
          <option value="5">Film</option>
          <option value="6">Curhat</option>
        </select>

        <label for="content">Isi Topik</label>
        <textarea id="content" name="content" rows="5" required></textarea>

        <button type="submit" class="btn btn-success">Posting Topik</button>
      </form>
    <?php else: ?>
      <button class="btn btn-warning" onclick="showLoginWarning()">Tambahkan Topik Baru</button>
    <?php endif; ?>


    <!-- Pesan Peringatan -->
    <div id="login-warning" class="alert alert-danger mt-3" role="alert" style="display: none;">
      Anda harus login terlebih dahulu untuk menambahkan topik baru!
    </div>

  </main>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Forum Diskusi. All rights reserved.</p>
  </footer>

  <script>
    // Menampilkan peringatan login
    function showLoginWarning() {
      const warning = document.getElementById('login-warning');
      warning.style.display = 'block';
      setTimeout(() => {
        warning.style.display = 'none';
      }, 3000); // Pesan akan hilang setelah 3 detik
    }

    // Menampilkan atau menyembunyikan formulir tambah topik
    function toggleAddTopicForm() {
      const form = document.getElementById('add-topic-form');
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
  </script>


</body>

</html>