<?php include 'navbar.php'; ?>
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 700px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        input[type="text"], input[type="number"] { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
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
    <h2>Data Barang</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; ?>">
        Nama Barang: <input type="text" name="nama" value="<?php if(isset($_GET['edit'])) { $id=$_GET['edit']; $q=mysqli_query($conn,"SELECT * FROM tb_barang WHERE id=$id"); $d=mysqli_fetch_assoc($q); echo $d['nama']; } ?>" required>
        Harga: <input type="number" name="harga" value="<?php if(isset($d)) echo $d['harga']; ?>" required>
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> Barang
        </button>
        <?php if(isset($_GET['edit'])): ?>
            <a href="barang.php" class="menu">Batal</a>
        <?php endif; ?>
    </form>
    <table>
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
            <td>Rp <?= number_format($row['harga'],0,',','.'); ?></td>
            <td>
                <a href="barang.php?edit=<?= $row['id']; ?>" class="menu">Edit</a>
                <a href="barang.php?hapus=<?= $row['id']; ?>" class="menu" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 