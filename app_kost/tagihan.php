<?php
include 'koneksi.php';

// Ambil data kamar-penghuni aktif
$kmr_penghuni = mysqli_query($conn, "SELECT r.id, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_kmr_penghuni r JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id WHERE r.tgl_keluar IS NULL OR r.tgl_keluar = ''");

// Handle generate tagihan
if (isset($_POST['generate'])) {
    $bulan = $_POST['bulan']; // format: YYYY-MM
    $id_kmr_penghuni = $_POST['id_kmr_penghuni'];
    // Hitung harga kamar
    $q = mysqli_query($conn, "SELECT k.harga, p.id_penghuni FROM tb_kmr_penghuni p JOIN tb_kamar k ON p.id_kamar=k.id WHERE p.id=$id_kmr_penghuni");
    $d = mysqli_fetch_assoc($q);
    $harga_kamar = $d['harga'];
    $id_penghuni = $d['id_penghuni'];
    // Hitung total harga barang bawaan
    $q2 = mysqli_query($conn, "SELECT SUM(b.harga) AS total_barang FROM tb_brng_bawaan a JOIN tb_barang b ON a.id_barang=b.id WHERE a.id_penghuni=$id_penghuni");
    $d2 = mysqli_fetch_assoc($q2);
    $total_barang = $d2['total_barang'] ?? 0;
    $jml_tagihan = $harga_kamar + $total_barang;
    // Insert tagihan
    mysqli_query($conn, "INSERT INTO tb_tagihan (bulan, id_kmr_penghuni, jml_tagihan) VALUES ('$bulan', '$id_kmr_penghuni', '$jml_tagihan')");
    header('Location: tagihan.php');
    exit;
}

// Ambil data tagihan
$tagihan = mysqli_query($conn, "SELECT t.*, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_tagihan t JOIN tb_kmr_penghuni r ON t.id_kmr_penghuni=r.id JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id ORDER BY t.bulan DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tagihan Penghuni</title>
</head>
<body>
    <h2>Generate Tagihan</h2>
    <form method="post">
        Bulan (YYYY-MM): <input type="month" name="bulan" required>
        Kamar - Penghuni:
        <select name="id_kmr_penghuni" required>
            <option value="">Pilih Kamar - Penghuni</option>
            <?php while($kp = mysqli_fetch_assoc($kmr_penghuni)) {
                echo "<option value='{$kp['id']}'>{$kp['nomor_kamar']} - {$kp['nama_penghuni']}</option>";
            } ?>
        </select>
        <button type="submit" name="generate">Generate Tagihan</button>
    </form>
    <br>
    <h2>Daftar Tagihan</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Kamar</th>
            <th>Penghuni</th>
            <th>Jumlah Tagihan</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($tagihan)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['bulan']); ?></td>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 