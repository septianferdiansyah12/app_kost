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
<html>
<head>
    <title>Barang Bawaan Penghuni</title>
</head>
<body>
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
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
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
                <a href="brng_bawaan.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 