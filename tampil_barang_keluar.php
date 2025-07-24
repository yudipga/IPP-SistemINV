\<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($koneksi, "
    SELECT bk.*, b.nama_barang 
    FROM barang_keluar bk 
    JOIN barang b ON bk.id_barang = b.id_barang
    ORDER BY bk.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang Keluar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="tampil_barang_keluar.css">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center mb-4">Data Barang Keluar</h3>

    <a href="barang_keluar.php" class="btn btn-success btn-sm mb-3">+ Tambah Barang Keluar</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                <td><?= $row['tujuan'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td>
                    <a href="edit_barang_keluar.php?id=<?= $row['id_keluar'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_barang_keluar.php?id=<?= $row['id_keluar'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="home.php" class="btn btn-secondary">← Kembali</a>
    </div>
</div>
</body>
</html>
