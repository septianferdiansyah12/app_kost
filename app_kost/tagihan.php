<?php include 'navbar.php'; ?>
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Penghuni</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 900px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        input[type="month"], select { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
        button, a.menu { background: #7eb6ff; color: #fff; border: none; border-radius: 5px; padding: 8px 18px; font-weight: 500; text-decoration: none; margin-right: 5px; transition: background 0.2s; cursor: pointer; }
        button:hover, a.menu:hover { background: #4f8cff; }
        table { width: 100%; border-collapse: collapse; background: #f5faff; border-radius: 7px; overflow: hidden; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #d6e6fa; text-align: left; }
        th { background: #7eb6ff; color: #fff; font-weight: 600; }
        tr:last-child td { border-bottom: none; }
        @media (max-width: 600px) { .container { padding: 10px; } th, td { font-size: 13px; } }
    </style>
</head>
<body>
<div class="container">
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
    <h2>Daftar Tagihan</h2>
    <table>
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
            <td>Rp <?= number_format($row['jml_tagihan'],0,',','.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 