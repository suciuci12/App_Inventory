<?php
include "koneksi.php";

$username = $_POST['username'];
$password_baru = $_POST['password_baru'];

mysqli_query($koneksi, "UPDATE users SET password='$password_baru' WHERE username='$username'");

header("Location: index.php");
?>
