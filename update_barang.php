<?php
include 'koneksi.php';

$id     = $_POST['id_barang'];
$kode   = $_POST['kode_barang'];
$nama   = $_POST['nama_barang'];
$desk   = $_POST['deskripsi_barang'];
$satuan = $_POST['satuan'];
$stok   = $_POST['stok'];
$deskripsi   = $_POST['deskripsi_barang'];

mysqli_query($koneksi, "UPDATE barang SET 
    kode_barang='$kode', 
    nama_barang='$nama', 
    deskripsi_barang='$desk',
    satuan='$satuan',
    stok='$stok' 
    WHERE id_barang='$id'");

header("Location: data_barang.php");
?>
