<?php include 'navbar.php'; ?>
<?php
include 'koneksi.php';

// 1. Kamar kosong (belum ditempati penghuni aktif)
$kamar_kosong = mysqli_query($conn, "SELECT k.* FROM tb_kamar k LEFT JOIN tb_kmr_penghuni r ON k.id = r.id_kamar AND (r.tgl_keluar IS NULL OR r.tgl_keluar = '') WHERE r.id IS NULL");

// 2. Kamar yang sebentar lagi harus bayar (tagihan bulan ini, status belum lunas)
$bulan_ini = date('Y-m');
$kamar_bayar = mysqli_query($conn, "SELECT t.*, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_tagihan t JOIN tb_kmr_penghuni r ON t.id_kmr_penghuni=r.id JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id WHERE t.bulan = '$bulan_ini' AND t.id NOT IN (SELECT id_tagihan FROM tb_bayar WHERE status='lunas')");

// 3. Kamar yang terlambat bayar (tagihan bulan lalu atau sebelumnya, status belum lunas)
$bulan_lalu = date('Y-m', strtotime('-1 month'));
$kamar_telat = mysqli_query($conn, "SELECT t.*, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_tagihan t JOIN tb_kmr_penghuni r ON t.id_kmr_penghuni=r.id JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id WHERE t.bulan <= '$bulan_lalu' AND t.id NOT IN (SELECT id_tagihan FROM tb_bayar WHERE status='lunas')");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Kost</title>
    <style>
        :root {
            --biru-soft: #7eb6ff;
            --biru-soft-dark: #4f8cff;
            --biru-bg: #eaf4ff;
            --biru-table: #f5faff;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--biru-bg);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 48px auto 0 auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(126,182,255,0.13);
            padding: 36px 32px 40px 32px;
        }
        h1 {
            color: var(--biru-soft-dark);
            text-align: center;
            margin-bottom: 28px;
            margin-top: 0;
            letter-spacing: 1px;
        }
        h2 {
            color: #2d3e50;
            border-left: 5px solid var(--biru-soft);
            padding-left: 12px;
            margin-top: 38px;
            margin-bottom: 18px;
            font-size: 1.25em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
            background: var(--biru-table);
            border-radius: 7px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 14px;
            border-bottom: 1px solid #d6e6fa;
            text-align: left;
        }
        th {
            background: var(--biru-soft);
            color: #fff;
            font-weight: 600;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .info-box {
            background: var(--biru-soft);
            border-left: 5px solid var(--biru-soft-dark);
            padding: 18px 22px;
            border-radius: 8px;
            margin-bottom: 32px;
            color: #2d3e50;
            font-size: 1.08em;
        }
        @media (max-width: 700px) {
            .container { padding: 10px; }
            th, td { font-size: 13px; }
            h1 { font-size: 1.2em; }
            h2 { font-size: 1em; }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Aplikasi Pengelolaan Kost</h1>
    <div class="info-box">
        Selamat datang di aplikasi pengelolaan kost!<br>
        Gunakan menu di atas untuk mengelola kamar, penghuni, barang, tagihan, dan pembayaran.
    </div>
    <h2>Daftar Kamar Kosong</h2>
    <table>
        <tr>
            <th>Nomor Kamar</th>
            <th>Harga Sewa</th>
        </tr>
        <?php if(mysqli_num_rows($kamar_kosong) > 0): while($row = mysqli_fetch_assoc($kamar_kosong)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor']); ?></td>
            <td>Rp <?= number_format($row['harga'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="2" style="text-align:center; color:#888;">Semua kamar terisi</td></tr>
        <?php endif; ?>
    </table>
    <h2>Kamar yang Sebentar Lagi Harus Bayar (Bulan Ini)</h2>
    <table>
        <tr>
            <th>Nomor Kamar</th>
            <th>Penghuni</th>
            <th>Jumlah Tagihan</th>
        </tr>
        <?php if(mysqli_num_rows($kamar_bayar) > 0): while($row = mysqli_fetch_assoc($kamar_bayar)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td>Rp <?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="3" style="text-align:center; color:#888;">Tidak ada tagihan bulan ini</td></tr>
        <?php endif; ?>
    </table>
    <h2>Kamar yang Terlambat Bayar</h2>
    <table>
        <tr>
            <th>Nomor Kamar</th>
            <th>Penghuni</th>
            <th>Bulan Tagihan</th>
            <th>Jumlah Tagihan</th>
        </tr>
        <?php if(mysqli_num_rows($kamar_telat) > 0): while($row = mysqli_fetch_assoc($kamar_telat)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= htmlspecialchars($row['bulan']); ?></td>
            <td>Rp <?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="4" style="text-align:center; color:#888;">Tidak ada keterlambatan pembayaran</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html> 