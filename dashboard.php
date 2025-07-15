<?php
include 'koneksi.php';
include 'navbar.php';

// Hitung jumlah kamar
$jumlah_kamar = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_kamar"))[0];
// Hitung jumlah penghuni
$jumlah_penghuni = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_penghuni WHERE tgl_keluar IS NULL OR tgl_keluar = ''"))[0];
// Hitung kamar kosong
$kamar_kosong = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_kamar k LEFT JOIN tb_kmr_penghuni r ON k.id = r.id_kamar AND (r.tgl_keluar IS NULL OR r.tgl_keluar = '') WHERE r.id IS NULL"))[0];
// Hitung tagihan bulan ini
$bulan_ini = date('Y-m');
$jumlah_tagihan = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_tagihan WHERE bulan = '$bulan_ini'"))[0];
// Hitung pembayaran bulan ini
$jumlah_bayar = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM tb_bayar b JOIN tb_tagihan t ON b.id_tagihan=t.id WHERE t.bulan = '$bulan_ini'"))[0];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard KostApp</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6fa; margin: 0; }
        .dashboard-container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 40px 40px 30px 40px; }
        h1 { color: #4f8cff; text-align: center; margin-bottom: 30px; }
        .cards { display: flex; flex-wrap: wrap; gap: 24px; justify-content: center; margin-bottom: 30px; }
        .card { background: #f4f6fa; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); padding: 28px 32px; min-width: 180px; text-align: center; flex: 1 1 180px; }
        .card-title { color: #2d3e50; font-size: 1.1em; margin-bottom: 8px; }
        .card-value { color: #4f8cff; font-size: 2.2em; font-weight: bold; }
        @media (max-width: 700px) { .dashboard-container { padding: 10px; } .cards { flex-direction: column; gap: 12px; } .card { padding: 18px 10px; } }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Dashboard KostApp</h1>
    <div class="cards">
        <div class="card">
            <div class="card-title">Total Kamar</div>
            <div class="card-value"><?= $jumlah_kamar ?></div>
        </div>
        <div class="card">
            <div class="card-title">Penghuni Aktif</div>
            <div class="card-value"><?= $jumlah_penghuni ?></div>
        </div>
        <div class="card">
            <div class="card-title">Kamar Kosong</div>
            <div class="card-value"><?= $kamar_kosong ?></div>
        </div>
        <div class="card">
            <div class="card-title">Tagihan Bulan Ini</div>
            <div class="card-value"><?= $jumlah_tagihan ?></div>
        </div>
        <div class="card">
            <div class="card-title">Pembayaran Bulan Ini</div>
            <div class="card-value"><?= $jumlah_bayar ?></div>
        </div>
    </div>
    <div style="text-align:center;">
        <a href="index.php" class="menu">Lihat Beranda</a>
    </div>
</div>
</body>
</html> 