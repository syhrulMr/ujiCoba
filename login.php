<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $loginInput = $_POST['login'];  // bisa username atau email
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = :loginInput OR email = :loginInput";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':loginInput', $loginInput);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['is_admin'] = $user['is_admin']; // Pastikan ini diatur
    header("Location: index.php");
    exit;
  } else {
    echo "Login gagal!";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <div class="background"></div>
  <div class="card">
    <img class="logo" src="logo.svg" alt="Logo" />
    <h2>Form Login</h2>
    <form action="login.php" method="POST" class="form">
      <label for="login">Username atau Email:</label>
      <input type="text" id="login" name="login" required placeholder="Username atau Email" />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required placeholder="Password" />

      <button type="submit">Login</button>
    </form>
    <footer>
      Need an account? Sign up <a href="register.php">here</a>
    </footer>
  </div>
</body>

</html>