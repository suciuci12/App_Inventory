<?php
session_start();
include "koneksi.php";

// Cek login (opsional tapi disarankan)
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Total jenis barang
$qJenis = mysqli_query($koneksi, "SELECT COUNT(*) AS jml_barang FROM inventory");
$dJenis = mysqli_fetch_assoc($qJenis);

// Total stok barang
$qStok = mysqli_query($koneksi, "SELECT SUM(stok) AS total_stok FROM inventory");
$dStok = mysqli_fetch_assoc($qStok);

// Total nilai persediaan (stok * harga)
$qNilai = mysqli_query($koneksi, "SELECT SUM(stok * harga) AS total_nilai FROM inventory");
$dNilai = mysqli_fetch_assoc($qNilai);

// Ringkasan per kategori
$qKategori = mysqli_query($koneksi, "
    SELECT kategori,
           SUM(stok) AS total_stok,
           SUM(stok * harga) AS total_nilai
    FROM inventory
    GROUP BY kategori
    ORDER BY kategori ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory</title>
    <!-- CSS sidebar + dashboard -->
    <link rel="stylesheet" href="stok.css">
    <!-- CSS kartu & tabel (sama seperti halaman stok) -->
    <link rel="stylesheet" href="laporan.css">
</head>
<body>

<div class="sidebar">
    <h2 class="logo">InventoryApp</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="stok.php">Stok Barang</a></li>
        <li class="active"><a href="laporan.php">Laporan</a></li>
        <li><a href="pengaturan.php">Pengaturan</a></li>
    </ul>

    <a href="logout.php" class="logout-btn">LOGOUT</a>
</div>

<div class="main-content">
    <h1>Laporan Inventory</h1>

    <!-- Kartu ringkasan -->
    <div class="cards">
        <div class="card">
            <h3>Total Jenis Barang</h3>
            <p><?php echo $dJenis['jml_barang']; ?></p>
        </div>

        <div class="card">
            <h3>Total Stok Barang</h3>
            <p><?php echo $dStok['total_stok'] !== null ? $dStok['total_stok'] : 0; ?></p>
        </div>

        <div class="card">
            <h3>Total Nilai Persediaan</h3>
            <p>Rp <?php echo number_format($dNilai['total_nilai'] ?? 0); ?></p>
        </div>
    </div>

    <hr>

    <h2>Ringkasan Stok per Kategori</h2>
    <div style="margin-bottom: 15px;text-align:right;">
    <a href="laporan2_pdf.php" target="_blank" class="btn-primary">Export PDF</a>
    </div>
    <table>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Total Stok</th>
            <th>Total Nilai</th>
        </tr>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($qKategori)) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['total_stok']; ?></td>
                <td>Rp <?php echo number_format($row['total_nilai']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
