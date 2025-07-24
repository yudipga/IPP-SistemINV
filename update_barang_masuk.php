<?php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_masuk'];
    $id_barang = $_POST['id_barang'];
    $id_supplier = $_POST['id_supplier'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $query = "UPDATE barang_masuk SET 
                id_barang = '$id_barang',
                id_supplier = '$id_supplier',
                jumlah = '$jumlah',
                tanggal = '$tanggal',
                keterangan = '$keterangan'
              WHERE id_masuk = '$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: tampil_barang_masuk.php");
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>
