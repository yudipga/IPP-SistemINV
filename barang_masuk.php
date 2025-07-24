<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang   = $_POST['id_barang'];
    $id_supplier = $_POST['id_supplier'];
    $jumlah      = $_POST['jumlah'];
    $tanggal     = $_POST['tanggal'];
    $keterangan  = $_POST['keterangan'];

    // Simpan ke tabel barang_masuk
    mysqli_query($koneksi, "INSERT INTO barang_masuk (id_barang, id_supplier, jumlah, tanggal, keterangan)
                            VALUES ('$id_barang', '$id_supplier', '$jumlah', '$tanggal', '$keterangan')");

    // Tambahkan stok ke tabel barang
    mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = '$id_barang'");

    header("Location: tampil_barang_masuk.php");
    exit;
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Barang Masuk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="barang_masuk.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Form Input Barang Masuk</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Barang</label>
            <select name="id_barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = mysqli_fetch_assoc($barang)) : ?>
                    <option value="<?= $row['id_barang'] ?>"><?= $row['nama_barang'] ?> (Stok: <?= $row['stok'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Supplier</label>
            <select name="id_supplier" class="form-select" required>
                <option value="">-- Pilih Supplier --</option>
                <?php while ($row = mysqli_fetch_assoc($supplier)) : ?>
                    <option value="<?= $row['id_supplier'] ?>"><?= $row['nama_supplier'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="tampil_barang_masuk.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
