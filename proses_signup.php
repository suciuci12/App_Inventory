<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
mysqli_query($koneksi, $query);

header("Location: index.php");
?>
