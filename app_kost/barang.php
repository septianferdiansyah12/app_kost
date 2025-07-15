<?php
include 'koneksi.php';

// Handle tambah barang
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $sql = "INSERT INTO tb_barang (nama, harga) VALUES ('$nama', '$harga')";
    mysqli_query($conn, $sql);
    header('Location: barang.php');
    exit;
}

// Handle hapus barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM tb_barang WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: barang.php');
    exit;
}

// Handle edit barang
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $sql = "UPDATE tb_barang SET nama='$nama', harga='$harga' WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: barang.php');
    exit;
}

// Ambil data barang
$barang = mysqli_query($conn, "SELECT * FROM tb_barang");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h2>Data Barang</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; ?>">
        Nama Barang: <input type="text" name="nama" value="<?php if(isset($_GET['edit'])) { $id=$_GET['edit']; $q=mysqli_query($conn,"SELECT * FROM tb_barang WHERE id=$id"); $d=mysqli_fetch_assoc($q); echo $d['nama']; } ?>" required>
        Harga: <input type="number" name="harga" value="<?php if(isset($d)) echo $d['harga']; ?>" required>
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> Barang
        </button>
        <?php if(isset($_GET['edit'])): ?>
            <a href="barang.php">Batal</a>
        <?php endif; ?>
    </form>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($barang)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= number_format($row['harga'],0,',','.'); ?></td>
            <td>
                <a href="barang.php?edit=<?= $row['id']; ?>">Edit</a> |
                <a href="barang.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html> 