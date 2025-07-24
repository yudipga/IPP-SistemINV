<?php
include 'koneksi.php';
require_once __DIR__ . '/vendor/autoload.php'; // Autoload mPDF

session_start(); // Untuk mengambil nama user login

// Ambil tanggal awal dan akhir dari parameter (atau default ke bulan ini)
$tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tgl_awal'] ?? date('Y-m-01'));
$tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tgl_akhir'] ?? date('Y-m-d'));

// Query data barang masuk
$masuk = mysqli_query($koneksi, "
    SELECT bm.*, b.nama_barang, s.nama_supplier 
    FROM barang_masuk bm
    JOIN barang b ON bm.id_barang = b.id_barang
    JOIN supplier s ON bm.id_supplier = s.id_supplier
    WHERE bm.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
    ORDER BY bm.tanggal DESC
");

// Query data barang keluar
$keluar = mysqli_query($koneksi, "
    SELECT bk.*, b.nama_barang 
    FROM barang_keluar bk
    JOIN barang b ON bk.id_barang = b.id_barang
    WHERE bk.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
    ORDER BY bk.tanggal DESC
");

// Mulai HTML
$html = "
<style>
    body { font-family: sans-serif; font-size: 12px; }
    h2, h4 { text-align: center; }
    table { border-collapse: collapse; width: 100%; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: center; }
    th { background-color: #e0e0e0; }
</style>

<h2>Riwayat Transaksi Barang</h2>
<h4>Periode: $tgl_awal s/d $tgl_akhir</h4>
";

// Tabel Barang Masuk
$html .= "
<h4>Barang Masuk</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Supplier</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>";
$no = 1;
while ($row = mysqli_fetch_assoc($masuk)) {
    $html .= "<tr>
        <td>{$no}</td>
        <td>{$row['nama_barang']}</td>
        <td>{$row['nama_supplier']}</td>
        <td>{$row['jumlah']}</td>
        <td>{$row['tanggal']}</td>
        <td>{$row['keterangan']}</td>
    </tr>";
    $no++;
}
$html .= "</tbody></table>";

// Tabel Barang Keluar
$html .= "
<h4 style='margin-top:30px;'>Barang Keluar</h4>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>";
$no = 1;
while ($row = mysqli_fetch_assoc($keluar)) {
    $html .= "<tr>
        <td>{$no}</td>
        <td>{$row['nama_barang']}</td>
        <td>{$row['jumlah']}</td>
        <td>{$row['tanggal']}</td>
        <td>{$row['keterangan']}</td>
    </tr>";
    $no++;
}
$html .= "</tbody></table>";

// Footer Cetak
$html .= "<br><small>Dicetak pada: " . date("d-m-Y H:i:s") . " oleh: " . ($_SESSION['username'] ?? 'Admin') . "</small>";

// Inisialisasi mPDF dan output PDF
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
$mpdf->WriteHTML($html);
$mpdf->Output("Riwayat_Transaksi_{$tgl_awal}_{$tgl_akhir}.pdf", 'I');
?>
