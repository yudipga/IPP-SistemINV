<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Ambil data barang
$barang = mysqli_query($koneksi, "SELECT * FROM barang");

// Ambil data yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($koneksi, "SELECT * FROM barang_keluar WHERE id_keluar = '$id'");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan.'); window.location.href='tampil_barang_keluar.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='tampil_barang_keluar.php';</script>";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $tujuan = $_POST['tujuan'];
    $keterangan = $_POST['keterangan'];

    $update = mysqli_query($koneksi, "UPDATE barang_keluar 
        SET id_barang = '$id_barang', jumlah = '$jumlah', tanggal = '$tanggal', tujuan = '$tujuan', keterangan = '$keterangan' 
        WHERE id_keluar = '$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui.'); window.location.href='tampil_barang_keluar.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>/* Reset dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body dengan background biru tua */
body {
    background-color: #0f172a; /* biru tua */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #f8fafc; /* teks putih lembut */
}

/* Container utama */
.container {
    max-width: 600px;
    margin: 40px auto;
    padding: 30px;
    background-color: #1e293b; /* biru lebih terang */
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Judul */
h3 {
    text-align: center;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 30px;
}

/* Label form */
label {
    font-weight: 600;
    color: #e2e8f0;
    display: block;
    margin-bottom: 6px;
}

/* Input, Select, Textarea */
input[type="text"],
input[type="number"],
input[type="date"],
select,
textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #334155;
    border-radius: 8px;
    background-color: #f8fafc;
    color: #0f172a;
    font-size: 14px;
    margin-bottom: 20px;
    transition: border-color 0.3s ease;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #38bdf8;
    outline: none;
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

.btn-primary {
    background-color: #0ea5e9; /* biru terang */
    color: white;
    margin-right: 10px;
}

.btn-primary:hover {
    background-color: #0284c7;
}

.btn-secondary {
    background-color: #64748b;
    color: white;
}

.btn-secondary:hover {
    background-color: #475569;
}

/* Responsive */
@media (max-width: 600px) {
    .container {
        padding: 20px;
    }

    h3 {
        font-size: 20px;
    }

    button, a.btn {
        width: 100%;
        margin-top: 10px;
    }
}
</style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Edit Data Barang Keluar</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="id_barang" class="form-label">Nama Barang</label>
            <select class="form-select" name="id_barang" id="id_barang" required>
                <?php while ($row = mysqli_fetch_assoc($barang)) : ?>
                    <option value="<?= $row['id_barang'] ?>" <?= $row['id_barang'] == $data['id_barang'] ? 'selected' : '' ?>>
                        <?= $row['nama_barang'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $data['tanggal'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" class="form-control" name="tujuan" id="tujuan" value="<?= $data['tujuan'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"><?= $data['keterangan'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="tampil_barang_keluar.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
