<?php
include 'koneksi.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: data_barang_masuk.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "
    SELECT * FROM barang_masuk WHERE id_masuk = '$id'
");
$data = mysqli_fetch_assoc($query);

// Ambil data barang & supplier untuk dropdown
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang Masuk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
         body {
    background-color: #0f172a; /* Biru tua */
    font-family: 'Segoe UI', sans-serif;
    color: #f1f5f9;
    margin: 0;
    padding: 0;
}

.container {
    margin-top: 50px;
}

.card {
    background-color: #aab7ccff; /* Lebih gelap dari background */
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    padding: 25px;
}

.card-header {
    background-color: #1d4ed8; /* Biru lebih cerah */
    color: #ffffff;
    font-weight: bold;
    font-size: 1.25rem;
    text-align: center;
    border-radius: 12px 12px 0 0;
}

.form-label {
    color: #e2e8f0;
    font-weight: 500;
}

.form-control,
.form-select {
    background-color: #334155;
    color: #ffffff;
    border: 1px solid #475569;
    border-radius: 8px;
    padding: 10px;
    transition: 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    background-color: #1e293b;
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.25);
    color: #ffffff;
}

.btn-success {
    background-color: #22c55e;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
}

.btn-success:hover {
    background-color: #16a34a;
}

.btn-secondary {
    background-color: #64748b;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: bold;
}

.btn-secondary:hover {
    background-color: #475569;
}

h4 {
    font-weight: bold;
    color: #ffffff;
    margin-bottom: 20px;
    text-align: center;
}
    </style>


</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Edit Data Barang Masuk</h3>
    <form action="update_barang_masuk.php" method="POST">
        <input type="hidden" name="id_masuk" value="<?= $data['id_masuk'] ?>">

        <div class="mb-3">
            <label>Nama Barang</label>
            <select name="id_barang" class="form-control" required>
                <?php while ($b = mysqli_fetch_assoc($barang)) : ?>
                    <option value="<?= $b['id_barang'] ?>" <?= $b['id_barang'] == $data['id_barang'] ? 'selected' : '' ?>>
                        <?= $b['nama_barang'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Supplier</label>
            <select name="id_supplier" class="form-control" required>
                <?php while ($s = mysqli_fetch_assoc($supplier)) : ?>
                    <option value="<?= $s['id_supplier'] ?>" <?= $s['id_supplier'] == $data['id_supplier'] ? 'selected' : '' ?>>
                        <?= $s['nama_supplier'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" value="<?= $data['keterangan'] ?>">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_barang_masuk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
