<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama_supplier ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="tampil_supplier.css">

</head>
<body>

<div class="container">
    <h3>Data Supplier</h3>

    <a href="supplier.php" class="btn btn-tambah btn-sm mb-3">+ Tambah Supplier</a>
    <a href="home.php" class="btn btn-secondary btn-sm mb-3 float-end">← Kembali</a>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['no_telp']) ?></td>
                <td class="text-center">
                    <a href="edit_supplier.php?id=<?= $row['id_supplier'] ?>" class="btn btn-edit btn-custom">Edit</a>
                    <a href="hapus_supplier.php?id=<?= $row['id_supplier'] ?>" class="btn btn-delete btn-custom" onclick="return confirm('Yakin ingin menghapus supplier ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
