<?php
include 'koneksi.php';

// Ambil data kamar dan penghuni untuk dropdown
$kamar = mysqli_query($conn, "SELECT * FROM tb_kamar");
$penghuni = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE tgl_keluar IS NULL OR tgl_keluar = ''");

// Handle tambah relasi
if (isset($_POST['tambah'])) {
    $id_kamar = $_POST['id_kamar'];
    $id_penghuni = $_POST['id_penghuni'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $sql = "INSERT INTO tb_kmr_penghuni (id_kamar, id_penghuni, tgl_masuk) VALUES ('$id_kamar', '$id_penghuni', '$tgl_masuk')";
    mysqli_query($conn, $sql);
    header('Location: kmr_penghuni.php');
    exit;
}

// Handle hapus relasi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM tb_kmr_penghuni WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: kmr_penghuni.php');
    exit;
}

// Handle edit relasi
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $id_kamar = $_POST['id_kamar'];
    $id_penghuni = $_POST['id_penghuni'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $sql = "UPDATE tb_kmr_penghuni SET id_kamar='$id_kamar', id_penghuni='$id_penghuni', tgl_masuk='$tgl_masuk', tgl_keluar='$tgl_keluar' WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: kmr_penghuni.php');
    exit;
}

// Ambil data relasi kamar-penghuni
$relasi = mysqli_query($conn, "SELECT r.*, k.nomor AS nomor_kamar, p.nama AS nama_penghuni FROM tb_kmr_penghuni r JOIN tb_kamar k ON r.id_kamar=k.id JOIN tb_penghuni p ON r.id_penghuni=p.id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Relasi Kamar - Penghuni</title>
</head>
<body>
    <h2>Relasi Kamar - Penghuni</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; ?>">
        Kamar:
        <select name="id_kamar" required>
            <option value="">Pilih Kamar</option>
            <?php
            $kamar2 = mysqli_query($conn, "SELECT * FROM tb_kamar");
            while($k = mysqli_fetch_assoc($kamar2)) {
                $selected = (isset($_GET['edit']) && isset($d) && $d['id_kamar'] == $k['id']) ? 'selected' : '';
                echo "<option value='{$k['id']}' $selected>{$k['nomor']}</option>";
            }
            ?>
        </select>
        Penghuni:
        <select name="id_penghuni" required>
            <option value="">Pilih Penghuni</option>
            <?php
            $penghuni2 = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE tgl_keluar IS NULL OR tgl_keluar = ''");
            while($p = mysqli_fetch_assoc($penghuni2)) {
                $selected = (isset($_GET['edit']) && isset($d) && $d['id_penghuni'] == $p['id']) ? 'selected' : '';
                echo "<option value='{$p['id']}' $selected>{$p['nama']}</option>";
            }
            ?>
        </select>
        Tanggal Masuk: <input type="date" name="tgl_masuk" value="<?php if(isset($_GET['edit'])) { $id=$_GET['edit']; $q=mysqli_query($conn,"SELECT * FROM tb_kmr_penghuni WHERE id=$id"); $d=mysqli_fetch_assoc($q); echo $d['tgl_masuk']; } ?>" required>
        Tanggal Keluar: <input type="date" name="tgl_keluar" value="<?php if(isset($d)) echo $d['tgl_keluar']; ?>">
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> Relasi
        </button>
        <?php if(isset($_GET['edit'])): ?>
            <a href="kmr_penghuni.php">Batal</a>
        <?php endif; ?>
    </form>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Kamar</th>
            <th>Penghuni</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($relasi)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nomor_kamar']); ?></td>
            <td><?= htmlspecialchars($row['nama_penghuni']); ?></td>
            <td><?= htmlspecialchars($row['tgl_masuk']); ?></td>
            <td><?= htmlspecialchars($row['tgl_keluar']); ?></td>
            <td>
                <a href="kmr_penghuni.php?edit=<?= $row['id']; ?>">Edit</a> |
                <a href="kmr_penghuni.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 