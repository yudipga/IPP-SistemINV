<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="data_barang.css">
    

</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-4">Data Barang</h3>

    <a href="tambah_barang.php" class="btn btn-success btn-sm mb-3">+ Tambah Barang</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Deskripsi Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
           <tbody>
    <?php $no = 1; foreach ($barang as $b): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $b['kode_barang'] ?></td>
        <td><?= $b['nama_barang'] ?></td>
        <td><?= $b['satuan'] ?></td>
        <td><?= $b['stok'] ?></td>
        <td><?= $b['deskripsi_barang'] ?></td>
        <td>
            <a href="edit_barang.php?id=<?= $b['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="hapus_barang.php?id=<?= $b['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="home.php" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</div>
</body>
</html>
