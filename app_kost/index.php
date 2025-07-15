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
<html>
<head>
    <title>Beranda Kost</title>
</head>
<body>
    <h2>Daftar Kamar Kosong</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nomor Kamar</th>
            <th>Harga Sewa</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($kamar_kosong)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor']); ?></td>
            <td><?= number_format($row['harga'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <h2>Kamar yang Sebentar Lagi Harus Bayar (Bulan Ini)</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nomor Kamar</th>
            <th>Penghuni</th>
            <th>Jumlah Tagihan</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($kamar_bayar)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <h2>Kamar yang Terlambat Bayar</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nomor Kamar</th>
            <th>Penghuni</th>
            <th>Bulan Tagihan</th>
            <th>Jumlah Tagihan</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($kamar_telat)): ?>
        <tr>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= htmlspecialchars($row['bulan']); ?></td>
            <td><?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="kamar.php">Kelola Kamar</a> |
    <a href="penghuni.php">Kelola Penghuni</a> |
    <a href="barang.php">Kelola Barang</a> |
    <a href="kmr_penghuni.php">Relasi Kamar-Penghuni</a> |
    <a href="brng_bawaan.php">Barang Bawaan</a> |
    <a href="tagihan.php">Tagihan</a> |
    <a href="bayar.php">Pembayaran</a>
</body>
</html> 