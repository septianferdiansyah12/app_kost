<?php include 'navbar.php'; ?>
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tagihan</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 900px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        select, input[type="number"] { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
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
    <h2>Riwayat Pembayaran</h2>
    <table>
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
            <td>Rp <?= number_format($row['jml_bayar'],0,',','.'); ?></td>
            <td><?= htmlspecialchars($row['status']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 