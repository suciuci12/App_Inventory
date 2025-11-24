<?php
session_start();
include "koneksi.php";

// Optional: cek sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peraturan & Panduan - InventoryApp</title>
    <link rel="stylesheet" href="setting.css">
</head>
<body>
<div class="layout">
       <div class="sidebar">
            <h2 class="logo">InventoryApp</h2>
            <ul>
                <li><a href="Dashboard.php">Dashboard</a></li>
                <li><a href="stok.php">Stok Barang</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li class="active"><a href="pengaturan.php">Pengaturan</a></li>
            </ul>
            <a href="logout.php" class="logout-btn">LOGOUT</a>
        </div>
    <main class="main-content">
        <header class="main-header">
            <h1>Peraturan & Panduan Penggunaan InventoryApp</h1>
            <p class="subtitle">
                Ikuti aturan yang berlaku
            </p>
        </header>
        <section class="card">
            <h2>1. Peraturan Umum</h2>
            <ul>
                <li>Setiap user wajib <strong>login</strong> menggunakan akun yang sudah terdaftar.</li>
                <li>Dilarang membagikan username dan password kepada orang lain.</li>
                <li>Perubahan data stok harus berdasarkan barang yang benar-benar masuk atau keluar.</li>
                <li>Data yang sudah dihapus tidak dapat dikembalikan, jadi pastikan sebelum menghapus.</li>
                <li>Gunakan fitur <strong>Laporan</strong> untuk memantau stok dan nilai persediaan secara berkala.</li>
            </ul>
        </section>

        <!-- KARTU HAK AKSES -->
        <section class="card">
            <h2>2. Hak Akses User</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Hak Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Admin</td>
                        <td>
                            Mengelola data user, menambah/mengubah/menghapus barang, melihat laporan,
                            mengatur kategori dan pengaturan aplikasi.
                        </td>
                    </tr>
                    <tr>
                        <td>Staff Gudang</td>
                        <td>
                            Menambah dan mengubah data barang, update stok, melihat laporan stok.
                        </td>
                    </tr>
                    <tr>
                        <td>Viewer</td>
                        <td>
                            Hanya dapat melihat data stok dan laporan, tanpa bisa mengubah data.
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- KARTU ALUR PENGELOLAAN STOK -->
        <section class="card">
            <h2>3. Alur Pengelolaan Stok</h2>

            <h3>a. Menambahkan Barang Baru</h3>
            <ol>
                <li>Buka menu <strong>Stok Barang</strong>.</li>
                <li>Klik tombol <strong>Tambah Barang</strong>.</li>
                <li>Isi nama barang, kategori, stok awal, dan harga.</li>
                <li>Klik <strong>Simpan</strong>.</li>
            </ol>

            <h3>b. Mengubah Data Barang</h3>
            <ol>
                <li>Pada tabel stok, cari barang yang ingin diubah.</li>
                <li>Klik tombol <strong>Edit</strong> di baris barang tersebut.</li>
                <li>Update data yang diperlukan (stok, harga, dll).</li>
                <li>Klik <strong>Update</strong>.</li>
            </ol>

            <h3>c. Menghapus Barang</h3>
            <ol>
                <li>Pilih barang pada tabel stok.</li>
                <li>Klik tombol <strong>Hapus</strong>.</li>
                <li>Pastikan muncul konfirmasi, lalu pilih <strong>Ya</strong> jika sudah yakin.</li>
            </ol>

            <h3>d. Melihat Laporan Inventory</h3>
            <ol>
                <li>Buka menu <strong>Laporan</strong>.</li>
                <li>Lihat ringkasan total jenis barang, total stok, dan total nilai persediaan.</li>
                <li>Gunakan tombol <strong>Export PDF</strong> untuk menyimpan laporan.</li>
            </ol>
        </section>

        <!-- KARTU CATATAN TAMBAHAN -->
        <section class="card">
            <h2>4. Catatan Penting</h2>
            <ul>
                <li>Lakukan pengecekan stok fisik secara berkala dan samakan dengan data di aplikasi.</li>
                <li>Jika terjadi selisih stok, segera koreksi di menu <strong>Stok Barang</strong> dan catat alasannya.</li>
                <li>Sebelum melakukan perubahan besar (misalnya penghapusan massal), sebaiknya simpan laporan PDF terlebih dahulu.</li>
            </ul>
        </section>

    </main>
</div>
</body>
</html>
