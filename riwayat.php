<?php
include 'koneksi.php';

$tgl_awal = $_GET['tgl_awal'] ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

// Barang Masuk
$barangMasuk = mysqli_query($koneksi, "
    SELECT 'Masuk' AS jenis, b.nama_barang, s.nama_supplier, bm.jumlah, bm.tanggal, bm.keterangan
    FROM barang_masuk bm
    JOIN barang b ON bm.id_barang = b.id_barang
    JOIN supplier s ON bm.id_supplier = s.id_supplier
    WHERE bm.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
");

// Barang Keluar
$barangKeluar = mysqli_query($koneksi, "
    SELECT 'Keluar' AS jenis, b.nama_barang, bk.tujuan AS Tujuan, bk.jumlah, bk.tanggal, bk.keterangan
    FROM barang_keluar bk
    JOIN barang b ON bk.id_barang = b.id_barang
    WHERE bk.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Barang Masuk dan Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
        }

        .filter-box {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="date"], .btn {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 0 5px;
        }

        .btn {
            background-color: #1d4ed8;
            color: #fff;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #dc2626;
        }

        table {
            border-collapse: collapse;
            background-color: #ffffff;
            color: #000;
            width: 100%;
            margin: 20px 0;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-size: 14px;
            word-wrap: break-word;
        }

        th {
            background-color: #f3f4f6;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tr:hover {
            background-color: #e0f2fe;
        }

        caption {
            background-color: #1e3a8a;
            color: white;
            font-weight: bold;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<h2>Riwayat Barang Masuk dan Barang Keluar</h2>
<h3>Periode: <?= $tgl_awal ?> sampai <?= $tgl_akhir ?></h3>

<div class="filter-box">
    <form method="GET">
        Dari: <input type="date" name="tgl_awal" value="<?= $tgl_awal ?>">
        Sampai: <input type="date" name="tgl_akhir" value="<?= $tgl_akhir ?>">
        <button type="submit" class="btn">Tampilkan</button>
        <a href="riwayat_pdf.php?tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>" target="_blank" class="btn btn-danger">Cetak PDF</a>
    </form>
</div>

<!-- Barang Masuk Table -->
<table>
    <caption>Barang Masuk</caption>
    <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 10%;">Jenis</th>
        <th style="width: 20%;">Nama Barang</th>
        <th style="width: 20%;">Supplier</th>
        <th style="width: 10%;">Jumlah</th>
        <th style="width: 15%;">Tanggal</th>
        <th style="width: 20%;">Keterangan</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($barangMasuk)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['jenis'] ?></td>
        <td><?= $row['nama_barang'] ?></td>
        <td><?= $row['nama_supplier'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['keterangan'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Barang Keluar Table -->
<table>
    <caption>Barang Keluar</caption>
    <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 10%;">Jenis</th>
        <th style="width: 20%;">Nama Barang</th>
        <th style="width: 20%;">Tujuan</th>
        <th style="width: 10%;">Jumlah</th>
        <th style="width: 15%;">Tanggal</th>
        <th style="width: 20%;">Keterangan</th>
    </tr>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($barangKeluar)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['jenis'] ?></td>
        <td><?= $row['nama_barang'] ?></td>
        <td><?= $row['Tujuan'] ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td><?= $row['keterangan'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
