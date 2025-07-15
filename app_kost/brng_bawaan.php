<?php include 'navbar.php'; ?>
<?php
include 'koneksi.php';

// Ambil data penghuni dan barang untuk dropdown
$penghuni = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE tgl_keluar IS NULL OR tgl_keluar = ''");
$barang = mysqli_query($conn, "SELECT * FROM tb_barang");

// Handle tambah barang bawaan
if (isset($_POST['tambah'])) {
    $id_penghuni = $_POST['id_penghuni'];
    $id_barang = $_POST['id_barang'];
    $sql = "INSERT INTO tb_brng_bawaan (id_penghuni, id_barang) VALUES ('$id_penghuni', '$id_barang')";
    mysqli_query($conn, $sql);
    header('Location: brng_bawaan.php');
    exit;
}

// Handle hapus barang bawaan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM tb_brng_bawaan WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: brng_bawaan.php');
    exit;
}

// Ambil data barang bawaan
$brng_bawaan = mysqli_query($conn, "SELECT b.id, p.nama AS nama_penghuni, g.nama AS nama_barang FROM tb_brng_bawaan b JOIN tb_penghuni p ON b.id_penghuni=p.id JOIN tb_barang g ON b.id_barang=g.id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Bawaan Penghuni</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 700px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        select { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
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
    <h2>Barang Bawaan Penghuni</h2>
    <form method="post">
        Penghuni:
        <select name="id_penghuni" required>
            <option value="">Pilih Penghuni</option>
            <?php
            $penghuni2 = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE tgl_keluar IS NULL OR tgl_keluar = ''");
            while($p = mysqli_fetch_assoc($penghuni2)) {
                echo "<option value='{$p['id']}'>{$p['nama']}</option>";
            }
            ?>
        </select>
        Barang:
        <select name="id_barang" required>
            <option value="">Pilih Barang</option>
            <?php
            $barang2 = mysqli_query($conn, "SELECT * FROM tb_barang");
            while($b = mysqli_fetch_assoc($barang2)) {
                echo "<option value='{$b['id']}'>{$b['nama']}</option>";
            }
            ?>
        </select>
        <button type="submit" name="tambah">Tambah Barang Bawaan</button>
    </form>
    <table>
        <tr>
            <th>No</th>
            <th>Penghuni</th>
            <th>Barang</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($brng_bawaan)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
            <td>
                <a href="brng_bawaan.php?hapus=<?= $row['id']; ?>" class="menu" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 