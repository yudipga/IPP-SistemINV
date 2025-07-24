<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='tampil_supplier.php';</script>";
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier = '$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan.'); window.location.href='tampil_supplier.php';</script>";
    exit;
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_supplier = htmlspecialchars(trim($_POST['nama_supplier']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $no_telp = htmlspecialchars(trim($_POST['no_telp']));

    $query = "UPDATE supplier 
              SET nama_supplier = '$nama_supplier', alamat = '$alamat', no_telp = '$no_telp' 
              WHERE id_supplier = '$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data supplier berhasil diperbarui!'); window.location.href='tampil_supplier.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>/* Reset dan dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #0f172a; /* Biru tua */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #f8fafc;
    padding: 20px;
}

/* Container form */
.container {
    max-width: 600px;
    margin: 40px auto;
    background-color: #1e293b; /* Lebih terang dari latar */
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

/* Judul form */
h3 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
}

/* Label form */
label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #e2e8f0;
}

/* Input dan textarea */
input[type="text"],
textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #334155;
    border-radius: 8px;
    background-color: #f8fafc;
    color: #0f172a;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

input:focus,
textarea:focus {
    border-color: #38bdf8;
    outline: none;
    background-color: #ffffff;
}

/* Tombol */
button,
a.btn {
    padding: 10px 16px;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: background-color 0.3s ease;
}

/* Tombol utama */
.
</style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Edit Data Supplier</h3>
    <form method="post">
        <div class="mb-3">
            <label for="nama_supplier" class="form-label">Nama Supplier</label>
            <input type="text" class="form-control" name="nama_supplier" id="nama_supplier" value="<?= $data['nama_supplier'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" required><?= $data['alamat'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?= $data['no_telp'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="tampil_supplier.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
