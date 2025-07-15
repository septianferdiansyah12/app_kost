<?php
include 'koneksi.php';

// Ambil data tagihan
$tagihan = mysqli_query($conn, "SELECT t.id, t.bulan, k.nomor AS nomor_kamar, p.nama AS nama_penghuni, t.jml_tagihan FROM tb_tagihan t JOIN tb_kmr_penghuni r ON t.id_kmr_penghuni=r.id JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id ORDER BY t.bulan DESC");

// Handle tambah pembayaran
if (isset($_POST['bayar'])) {
    $id_tagihan = $_POST['id_tagihan'];
    $jml_bayar = $_POST['jml_bayar'];
    $status = $_POST['status'];
    mysqli_query($conn, "INSERT INTO tb_bayar (id_tagihan, jml_bayar, status) VALUES ('$id_tagihan', '$jml_bayar', '$status')");
    header('Location: bayar.php');
    exit;
}

// Ambil data pembayaran
$bayar = mysqli_query($conn, "SELECT b.*, t.bulan, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_bayar b JOIN tb_tagihan t ON b.id_tagihan=t.id JOIN tb_kmr_penghuni r ON t.id_kmr_penghuni=r.id JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id ORDER BY b.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Tagihan</title>
</head>
<body>
    <h2>Pembayaran Tagihan</h2>
    <form method="post">
        Tagihan:
        <select name="id_tagihan" required>
            <option value="">Pilih Tagihan</option>
            <?php while($t = mysqli_fetch_assoc($tagihan)) {
                echo "<option value='{$t['id']}'>{$t['bulan']} - Kamar {$t['nomor_kamar']} - {$t['nama_penghuni']} (Rp ".number_format($t['jml_tagihan'],0,',','.').")</option>";
            } ?>
        </select>
        Jumlah Bayar: <input type="number" name="jml_bayar" required>
        Status:
        <select name="status" required>
            <option value="lunas">Lunas</option>
            <option value="cicil">Cicil</option>
        </select>
        <button type="submit" name="bayar">Bayar</button>
    </form>
    <br>
    <h2>Riwayat Pembayaran</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Kamar</th>
            <th>Penghuni</th>
            <th>Jumlah Bayar</th>
            <th>Status</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($bayar)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['bulan']); ?></td>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= number_format($row['jml_bayar'],0,',','.'); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 