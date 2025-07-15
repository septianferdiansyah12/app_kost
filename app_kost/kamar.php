<?php
include 'koneksi.php';

// Handle tambah kamar
if (isset($_POST['tambah'])) {
    $nomor = $_POST['nomor'];
    $harga = $_POST['harga'];
    $sql = "INSERT INTO tb_kamar (nomor, harga) VALUES ('$nomor', '$harga')";
    mysqli_query($conn, $sql);
    header('Location: kamar.php');
    exit;
}

// Handle hapus kamar
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM tb_kamar WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: kamar.php');
    exit;
}

// Handle edit kamar
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nomor = $_POST['nomor'];
    $harga = $_POST['harga'];
    $sql = "UPDATE tb_kamar SET nomor='$nomor', harga='$harga' WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: kamar.php');
    exit;
}

// Ambil data kamar
$kamar = mysqli_query($conn, "SELECT * FROM tb_kamar");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kamar</title>
</head>
<body>
    <h2>Data Kamar</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; ?>">
        Nomor Kamar: <input type="text" name="nomor" value="<?php if(isset($_GET['edit'])) { $id=$_GET['edit']; $q=mysqli_query($conn,"SELECT * FROM tb_kamar WHERE id=$id"); $d=mysqli_fetch_assoc($q); echo $d['nomor']; } ?>" required>
        Harga: <input type="number" name="harga" value="<?php if(isset($d)) echo $d['harga']; ?>" required>
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> Kamar
        </button>
        <?php if(isset($_GET['edit'])): ?>
            <a href="kamar.php">Batal</a>
        <?php endif; ?>
    </form>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nomor Kamar</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($kamar)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nomor']); ?></td>
            <td><?= number_format($row['harga'],0,',','.'); ?></td>
            <td>
                <a href="kamar.php?edit=<?= $row['id']; ?>">Edit</a> |
                <a href="kamar.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 