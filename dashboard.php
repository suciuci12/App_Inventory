<?php
session_start();                     // Nyalain session, biar bisa cek siapa yang login
include "koneksi.php";               // Sambungin file ini ke database

// Cek login (opsional)
if (!isset($_SESSION['username'])) { // Kalo belum login
    header("Location: index.php"); // Harusnya dilempar ke login
    exit();                         // Stop program
}

// PROSES TAMBAH / EDIT DATA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {   // Kalo user ngeklik tombol submit

    // Ngambil data dari form
    $nama_barang = trim($_POST['nama_barang']);  // Nama barang (dirapihin pake trim)
    $kategori    = trim($_POST['kategori']);     // Kategori barang
    $stok        = trim($_POST['stok']);         // Stok barang
    $harga       = trim($_POST['harga']);        // Harga barang
    $aksi        = $_POST['aksi'];               // Mau tambah atau edit

    // Kalau user pilih tambah barang
    if ($aksi == "tambah") {
        // Query buat insert data baru
        $sql = "INSERT INTO inventory (nama_barang, kategori, stok, harga)
                VALUES ('$nama_barang', '$kategori', '$stok', '$harga')";
        mysqli_query($koneksi, $sql);            // Eksekusi ke database

    // Kalau user lagi edit barang
    } elseif ($aksi == "edit") {
        $id = (int) $_POST['id'];                // ID barang yang mau diedit
        // Query update datanya
        $sql = "UPDATE inventory 
                SET nama_barang='$nama_barang', kategori='$kategori', stok='$stok', harga='$harga'
                WHERE id=$id";
        mysqli_query($koneksi, $sql);            // Eksekusi update
    }

    header("Location: dashboard.php");           // Abis tambah/edit balik lagi ke dashboard
    exit();
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {                     // Kalo tombol hapus dipencet
    $id = (int) $_GET['hapus'];                  // Ambil ID barang
    mysqli_query($koneksi, "DELETE FROM inventory WHERE id=$id");  // Hapus dari database

    header("Location: dashboard.php");           // Refresh halaman
    exit();
}

// MODE EDIT
$editMode = false;                               // Default: ga lagi edit
$editData = ['id'=>'','nama_barang'=>'','kategori'=>'','stok'=>'','harga'=>'']; // Data kosong

if (isset($_GET['edit'])) {                      // Kalo user klik tombol edit
    $editMode = true;                            // Nyalain mode edit
    $id = (int) $_GET['edit'];                   // Ambil ID barang

    $result = mysqli_query($koneksi, "SELECT * FROM inventory WHERE id=$id"); // Ambil datanya
    $editData = mysqli_fetch_assoc($result);     // Simpan ke variabel buat isi form
}

// AMBIL SEMUA DATA INVENTORY
$data = mysqli_query($koneksi, "SELECT * FROM inventory ORDER BY id ASC");  // Ambil seluruh barang
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">                        <!-- Set karakter biar aman -->
    <title>Dashboard Inventory</title>            <!-- Judul tab -->
    <link rel="stylesheet" href="Dashboard.css">  <!-- CSS dashboard -->
</head>
<body>

<!-- SIDEBAR KIRI -->
<div class="sidebar">
    <h2 class="logo">InventoryApp</h2>            <!-- Nama aplikasi -->

    <ul>
        <!-- Menu sidebar -->
        <li class="active"><a href="Dashboard.php">Dashboard</a></li>      <!-- Halaman sekarang -->
        <li><a href="stok.php">Stok Barang</a></li>                       <!-- Ke halaman stok -->
        <li><a href="laporan.php">Laporan</a></li>                        <!-- Ke laporan -->
        <li><a href="Pengaturan.php">Pengaturan</a></li>                  <!-- Pengaturan -->
    </ul>

    <a href="logout.php">LOGOUT</a>                <!-- Tombol logout -->
</div>

<!-- BAGIAN KONTEN UTAMA -->
<div class="content">
    <h1>Dashboard Inventory</h1>                   <!-- Judul halaman -->

    <!-- FORM TAMBAH / EDIT BARANG -->
    <div class="card form-card">
        <h2><?= $editMode ? "Edit Barang" : "Tambah Barang" ?></h2> <!-- Judul berubah otomatis -->

        <form action="" method="POST">             <!-- Form submit -->

            <?php if ($editMode): ?>              <!-- Kalo mode edit -->
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">  <!-- Kirim ID barang -->
            <?php endif; ?>

            <!-- Input nama barang -->
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" required value="<?= $editData['nama_barang'] ?>">

            <!-- Input kategori -->
            <label>Kategori</label>
            <input type="text" name="kategori" required value="<?= $editData['kategori'] ?>">

            <!-- Input stok -->
            <label>Stok</label>
            <input type="number" name="stok" required value="<?= $editData['stok'] ?>">

            <!-- Input harga -->
            <label>Harga</label>
            <input type="number" name="harga" required value="<?= $editData['harga'] ?>">

            <!-- Tentuin aksi submit: tambah atau edit -->
            <input type="hidden" name="aksi" value="<?= $editMode ? "edit":"tambah" ?>">

            <!-- Tombol simpan -->
            <button type="submit" class="btn-primary">
                <?= $editMode ? "Update" : "Tambah" ?>   <!-- Tulisannya berubah otomatis -->
            </button>

            <?php if ($editMode): ?>                       <!-- Tombol batal saat edit -->
                <a href="dashboard.php" class="btn-secondary">Batal</a>
            <?php endif; ?>

        </form>
    </div>

    <!-- TABEL DAFTAR BARANG -->
    <div class="card">
        <h2>Data Inventory</h2>                 <!-- Judul tabel -->

        <table>
            <thead>                               <!-- Header kolom -->
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>                               <!-- Isi tabel -->
                <?php while ($row = mysqli_fetch_assoc($data)): ?>   <!-- Loop semua barang -->
                <tr>
                    <td><?= $row['id'] ?></td>                     <!-- ID barang -->
                    <td><?= $row['nama_barang'] ?></td>            <!-- Nama -->
                    <td><?= $row['kategori'] ?></td>               <!-- Kategori -->
                    <td><?= $row['stok'] ?></td>                   <!-- Stok -->
                    <td>Rp <?= number_format($row['harga']) ?></td><!-- Harga format rupiah -->
                    <td>
                        <!-- Tombol edit -->
                        <a href="dashboard.php?edit=<?= $row['id'] ?>" class="btn-warning">Edit</a>

                        <!-- Tombol hapus + konfirmasi -->
                        <a href="dashboard.php?hapus=<?= $row['id'] ?>" class="btn-danger"
                           onclick="return confirm('Hapus barang?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>              <!-- Akhir looping -->
            </tbody>
        </table>   

    </div>

</div>

</body>
</html>
