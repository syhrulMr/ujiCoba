<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $password);

  if ($stmt->execute()) {
    header("Location: login.php");
    exit;
  } else {
    echo "Gagal mendaftar!";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Daftar</title>
  <link rel="stylesheet" href="css/regis.css">
</head>

<body>
  <h2>Form Pendaftaran</h2>
  <form action="register.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Daftar</button>
  </form>
</body>

</html>