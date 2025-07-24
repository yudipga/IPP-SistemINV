<?php
include 'koneksi.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM barang_masuk WHERE id_masuk = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: tampil_barang_masuk.php");
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    header("Location: tampil_barang_masuk.php");
}
?>
