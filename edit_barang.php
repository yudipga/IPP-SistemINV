<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$d = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="edit_barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Barang</h2>
    
    <form method="POST" action="update_barang.php" class="p-4 border rounded bg-light shadow">
        <input type="hidden" name="id_barang" value="<?= $d['id_barang'] ?>">
        
        <div class="mb-3">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" value="<?= $d['kode_barang'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= $d['nama_barang'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Barang</label>
            <textarea name="deskripsi_barang" class="form-control" rows="3" required><?= $d['deskripsi_barang'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" name="satuan" class="form-control" value="<?= $d['satuan'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $d['stok'] ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
</body>
</html>
