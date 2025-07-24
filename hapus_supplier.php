<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM supplier WHERE id_supplier = '$id'";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data supplier berhasil dihapus!'); window.location.href='tampil_supplier.php';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.href='tampil_supplier.php';</script>";
}
?>
