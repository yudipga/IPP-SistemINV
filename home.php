<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';

$result_barang = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang");
$jumlah_barang = mysqli_fetch_assoc($result_barang)['total'];

$result_masuk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang_masuk");
$jumlah_masuk = mysqli_fetch_assoc($result_masuk)['total'];

$result_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang_keluar");
$jumlah_keluar = mysqli_fetch_assoc($result_keluar)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo ipp.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            transition: all 0.3s;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #002760;
            color: white;
            transition: width 0.3s;
            overflow-x: hidden;
            z-index: 1000;
        }

        .sidebar.shrink {
            width: 80px;
        }

        .sidebar .text-center img {
            height: 50px;
            transition: all 0.3s;
        }

        .sidebar.shrink .sidebar-title,
        .sidebar.shrink h6,
        .sidebar.shrink a span {
            display: none;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: all 0.2s;
        }

        .sidebar a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #04347c;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s;
        }

        .sidebar.shrink + .main-content {
            margin-left: 80px;
        }

        .toggle-btn {
            background-color: #2456a0;
            color: white;
            border: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            border-radius: 5px;
            width: 36px;
            height: 36px;
            font-size: 18px;
        }

        .zoom-box {
            background: #2456a0;
            padding: 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .zoom-box:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body>

<!-- Toggle Button -->
<button class="toggle-btn" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="text-center mb-4 px-3 pt-3">
        <img src="img/logo ipp.png" alt="Logo" class="rounded shadow">
        <h5 class="sidebar-title fw-bold mt-2">PT. INTI PAKET PRIMA</h5>
        <h6>Dashboard</h6>
    </div>
    <a href="home.php" class="active"><i class="fas fa-home"></i><span>Home</span></a>
    <a href="data_barang.php"><i class="fas fa-box"></i><span>Data Barang</span></a>
    <a href="tampil_barang_masuk.php"><i class="fas fa-arrow-down"></i><span>Barang Masuk</span></a>
    <a href="tampil_barang_keluar.php"><i class="fas fa-arrow-up"></i><span>Barang Keluar</span></a>
    <a href="tampil_supplier.php"><i class="fas fa-truck"></i><span>Supplier</span></a>
    <a href="riwayat.php"><i class="fas fa-history"></i><span>Riwayat</span></a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>

<!-- Konten -->
<div class="main-content" id="main-content">
    <div class="zoom-box mb-4">
        <h3>Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h3>
        <p>Silakan gunakan menu di sebelah kiri untuk mengelola inventaris.</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="zoom-box text-center" style="background-color:#1E88E5;">
                <h5>Total Data Barang</h5>
                <h2><?= $jumlah_barang ?></h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="zoom-box text-center" style="background-color:#43A047;">
                <h5>Total Barang Masuk</h5>
                <h2><?= $jumlah_masuk ?></h2>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="zoom-box text-center" style="background-color:#E53935;">
                <h5>Total Barang Keluar</h5>
                <h2><?= $jumlah_keluar ?></h2>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <canvas id="barChart"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script>
    const jumlahMasuk = <?= $jumlah_masuk ?>;
    const jumlahKeluar = <?= $jumlah_keluar ?>;
    const totalBarang = <?= $jumlah_barang ?>;

    const barCtx = document.getElementById('barChart').getContext('2d');
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Barang Masuk', 'Barang Keluar'],
            datasets: [{
                label: 'Jumlah',
                data: [jumlahMasuk, jumlahKeluar],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Grafik Barang Masuk vs Barang Keluar' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Barang Masuk', 'Barang Keluar', 'Total Barang'],
            datasets: [{
                data: [jumlahMasuk, jumlahKeluar, totalBarang],
                backgroundColor: ['#2196F3', '#FF9800', '#9C27B0']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Distribusi Data Barang' }
            }
        }
    });

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("shrink");
        document.getElementById("main-content").classList.toggle("expanded");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
