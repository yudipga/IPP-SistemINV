<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_supplier = $_POST['nama_supplier'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    $query = "INSERT INTO supplier (nama_supplier, alamat, no_telp)
              VALUES ('$nama_supplier', '$alamat', '$no_telp')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data supplier berhasil disimpan!'); window.location.href='tampil_supplier.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Supplier</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a; /* Biru tua */
            color: #f8fafc;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #1e293b;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #e2e8f0;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #475569;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            background-color: #334155;
            color: white;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #0ea5e9;
            outline: none;
            background-color: #1e293b;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        button[type="submit"] {
            flex: 1;
            padding: 12px;
            background-color: #26c6d8ff;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #3c85d2ff;
        }

        .btn-back {
            flex: 1;
            text-align: center;
            padding: 12px;
            background-color: #64748b;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #e91f04ff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Form Tambah Supplier</h2>
    <form method="post">
        <div>
            <label for="nama_supplier">Nama Supplier</label>
            <input type="text" name="nama_supplier" id="nama_supplier" required>
        </div>
        <div>
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" required></textarea>
        </div>
        <div>
            <label for="no_telp">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" required>
        </div>
        <div class="btn-group">
            <button type="submit">Simpan</button>
            <a class="btn-back" href="tampil_supplier.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
