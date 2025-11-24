<?php
$host     = "localhost";
$user     = "root";      // default XAMPP
$password = "";          // default XAMPP kosong
$db       = "login";

$koneksi = mysqli_connect($host, $user, $password, $db);

// Cek koneksi
if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// echo "Koneksi berhasil"; // bisa kamu test dulu
?>
