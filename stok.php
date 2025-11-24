<?php
session_start(); // Memulai session agar bisa akses data login pengguna
include "koneksi.php"; // Menghubungkan file ini dengan database

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) { // Jika 'username' tidak ada di session
    header("Location: index.php"); // Arahkan kembali ke halaman login
    exit(); // Hentikan proses script
}

// Query menghitung total stok (menjumlahkan semua kolom stok)
$qTotalStok   = mysqli_query($koneksi, "SELECT SUM(stok) AS total_stok FROM inventory");
// Mengubah hasil query menjadi array
$dTotalStok   = mysqli_fetch_assoc($qTotalStok);

// Query menghitung berapa jumlah barang (jumlah baris di tabel inventory)
$qJumlahBarang = mysqli_query($koneksi, "SELECT COUNT(*) AS jml_barang FROM inventory");
$dJumlahBarang = mysqli_fetch_assoc($qJumlahBarang);

// Query mengambil seluruh data barang untuk ditampilkan di tabel
$qData = mysqli_query($koneksi, "SELECT nama_barang, kategori, stok FROM inventory ORDER BY nama_barang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Set karakter bahasa -->
    <title>Stok Barang</title> <!-- Judul halaman -->
    <link rel="stylesheet" href="stok.css"> <!-- Memanggil file CSS -->
</head>
<body>
    <div class="wrapper"> <!-- Container utama layout -->
        <div class="sidebar"> <!-- Bagian kiri sidebar -->
            <h2 class="logo">InventoryApp</h2> <!-- Logo atau nama aplikasi -->
             <ul>
                    <!-- Menu navigasi -->
                    <li><a href="Dashboard.php">Dashboard</a></li>
                    <li class="active"><a href="stok.php">Stok Barang</a></li> <!-- Halaman aktif -->
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="pengaturan.php">Pengaturan</a></li>
            </ul>
            <a href="logout.php" class="logout-btn">LOGOUT</a> <!-- Tombol logout -->
        </div>

        <div class="main-content"> <!-- Area utama isi halaman -->
            <h1>Halaman Stok</h1> <!-- Judul halaman -->

            <div class="cards"> <!-- Kotak ringkasan -->
                <div class="card">
                    <h3>Total Jenis Barang</h3>
                    <!-- Menampilkan jumlah data barang -->
                    <p><?php echo $dJumlahBarang['jml_barang']; ?></p>
                </div>
                <div class="card">
                    <h3>Total Stok Barang</h3>
                    <!-- Jika total stok NULL, tampilkan 0 -->
                    <p><?php echo $dTotalStok['total_stok'] !== null ? $dTotalStok['total_stok'] : 0; ?></p>
                </div>
            </div>

            <hr> <!-- Garis pemisah -->

            <h2>Detail Stok per Barang</h2> <!-- Judul tabel -->

            <!-- Tabel daftar barang -->
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>No</th> <!-- Nomor urut -->
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>

                <?php 
                $no = 1; // Untuk nomor baris tabel dimulai dari 1

                // Perulangan untuk menampilkan setiap data barang
                while ($row = mysqli_fetch_assoc($qData)) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td> <!-- Nomor urut bertambah tiap baris -->
                        <td><?php echo $row['nama_barang']; ?></td> <!-- Nama barang -->
                        <td><?php echo $row['kategori']; ?></td> <!-- Kategori barang -->
                        <td>
                            <?php 
                                // Jika stok kurang dari 10, beri warna merah dan tulisan "Menipis"
                                if ($row['stok'] < 10) {
                                    echo "<span style='color:red;font-weight:bold'>" . $row['stok'] . " (Menipis)</span>";
                                } else {
                                    // Jika stok aman tampilkan angka biasa
                                    echo $row['stok'];
                                }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>
