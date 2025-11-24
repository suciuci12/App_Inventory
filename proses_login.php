<?php
// proses_login.php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query cek user
  $sql  = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
  $result = mysqli_query($koneksi, $sql);  

  if (mysqli_num_rows($result) == 1) {
    // Login sukses
    $row = mysqli_fetch_assoc($result);

    // Simpan ke session
    $_SESSION['user_id']  = $row['id'];
    $_SESSION['username'] = $row['username'];

    // Redirect ke dashboard
    header("Location: dashboard.php");
    exit();
  } else {
    // Login gagal
    $_SESSION['error'] = "Username atau password salah!";
    header("Location: index.php");
    exit();
  }
} else {
  // Jika bukan method POST
  header("Location: dashboard.php");
  exit();
}
?>
