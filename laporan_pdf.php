<?php
require 'vendor/autoload.php';        // autoload dari Composer
include "koneksi.php";

use Dompdf\Dompdf;

// ambil data sama seperti di laporan.php

// Total jenis barang
$qJenis = mysqli_query($koneksi, "SELECT COUNT(*) AS jml_barang FROM inventory");
$dJenis = mysqli_fetch_assoc($qJenis);

// Total stok
$qStok = mysqli_query($koneksi, "SELECT SUM(stok) AS total_stok FROM inventory");
$dStok = mysqli_fetch_assoc($qStok);

// Total nilai persediaan
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

// mulai buat HTML untuk PDF
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        h1 { text-align:center; margin-bottom:10px; }
        h3 { margin: 8px 0 4px; }
        .summary {
            width:100%;
            margin-bottom:15px;
        }
        .summary td {
            padding:4px 6px;
        }
        table {
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }
        table th, table td {
            border:1px solid #000;
            padding:6px;
            text-align:left;
            font-size:11px;
        }
        table th {
            background:#e5e7eb;
        }
      
    </style>
</head>
<body>

<h1>Laporan Inventory</h1>

<table class="summary">
    <tr>
        <td><strong>Total Jenis Barang</strong></td>
        <td>: ' . $dJenis["jml_barang"] . '</td>
    </tr>
    <tr>
        <td><strong>Total Stok Barang</strong></td>
        <td>: ' . ($dStok["total_stok"] ?? 0) . '</td>
    </tr>
    <tr>
        <td><strong>Total Nilai Persediaan</strong></td>
        <td>: Rp ' . number_format($dNilai["total_nilai"] ?? 0, 0, ",", ".") . '</td>
    </tr>
</table>

<h3>Ringkasan Stok per Kategori</h3>
<table>
    <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Total Stok</th>
        <th>Total Nilai</th>
    </tr>';

$no = 1;
while ($row = mysqli_fetch_assoc($qKategori)) {
    $html .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . $row["kategori"] . '</td>
        <td>' . $row["total_stok"] . '</td>
        <td>Rp ' . number_format($row["total_nilai"], 0, ",", ".") . '</td>
    </tr>';
}

$html .= '
</table>

</body>
</html>
';

// generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// ukuran kertas & orientasi (A4 potrait)
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

// download file
$dompdf->stream("laporan_inventory.pdf", ["Attachment" => true]);
?>