<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['admin_password'];

    // Periksa password admin di database
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE password = :password");
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['is_admin'] = true;
        header('Location: admin-dashboard.php');
    } else {
        $_SESSION['error'] = 'Password salah!';
        header('Location: index.php');
    }
    exit;
}
?>
