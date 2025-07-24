<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang  = $_POST['id_barang'];
    $jumlah     = $_POST['jumlah'];
    $tanggal    = $_POST['tanggal'];
    $tujuan     = $_POST['tujuan'];
    $keterangan = $_POST['keterangan'];

    // Simpan ke tabel barang_keluar
    mysqli_query($koneksi, "INSERT INTO barang_keluar (id_barang, jumlah, tanggal, tujuan, keterangan)
                            VALUES ('$id_barang', '$jumlah', '$tanggal', '$tujuan', '$keterangan')");

    // Kurangi stok di tabel barang
    mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang = '$id_barang'");

    header("Location: tampil_barang_keluar.php");
    exit;
}

// Ambil data barang untuk dropdown
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Barang Keluar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="barang_keluar.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Form Input Barang Keluar</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Barang</label>
            <select name="id_barang" class="form-select" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($row = mysqli_fetch_assoc($barang)): ?>
                    <option value="<?= $row['id_barang'] ?>"><?= $row['nama_barang'] ?> (Stok: <?= $row['stok'] ?>)</option>
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
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="tampil_barang_keluar.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
