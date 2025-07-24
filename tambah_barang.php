<?php
include 'koneksi.php';

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $stok = $_POST['stok'];
    $deskripsi_barang = $_POST['deskripsi_barang'];

    // Simpan ke database
    $query = "INSERT INTO barang (kode_barang, nama_barang, satuan, stok, deskripsi_barang)
              VALUES ('$kode_barang', '$nama_barang', '$satuan', '$stok', '$deskripsi_barang')";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        echo "<script>alert('Barang berhasil ditambahkan'); window.location.href='data_barang.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="tambah_barang.css">
</head>
<body>
    <div class="container">
        <h2>Form Tambah Barang</h2>
        <form method="POST" action="">

            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang" required>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" required>
            </div>

            <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan" id="satuan" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" min="0" required>
            </div>

            <div class="form-group">
                <label for="deskripsi_barang">Deskripsi Barang</label>
                <input type="text" name="deskripsi_barang" id="deskripsi_barang" required>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-submit">Simpan</button>
                <a class="btn-back" href="data_barang.php">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
