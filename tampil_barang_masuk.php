<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT bm.*, b.nama_barang, s.nama_supplier
    FROM barang_masuk bm
    JOIN barang b ON bm.id_barang = b.id_barang
    JOIN supplier s ON bm.id_supplier = s.id_supplier
    ORDER BY bm.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang Masuk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="tampil_barang_masuk.css">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-4">Data Barang Masuk</h3>

    <a href="barang_masuk.php" class="btn btn-success btn-sm mb-3">Input Barang Masuk</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['nama_supplier'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td>
                        <a href="edit_barang_masuk.php?id=<?= $row['id_masuk'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_barang_masuk.php?id=<?= $row['id_masuk'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="home.php" class="btn btn-secondary btn-sm mb-3">Home</a>
</div>
</body>
</html>
