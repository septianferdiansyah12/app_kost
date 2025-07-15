<?php include 'navbar.php'; ?>
<?php
include 'koneksi.php';

// Handle tambah penghuni
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $sql = "INSERT INTO tb_penghuni (nama, no_ktp, no_hp, tgl_masuk) VALUES ('$nama', '$no_ktp', '$no_hp', '$tgl_masuk')";
    mysqli_query($conn, $sql);
    header('Location: penghuni.php');
    exit;
}

// Handle hapus penghuni
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM tb_penghuni WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: penghuni.php');
    exit;
}

// Handle edit penghuni
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $sql = "UPDATE tb_penghuni SET nama='$nama', no_ktp='$no_ktp', no_hp='$no_hp', tgl_masuk='$tgl_masuk', tgl_keluar='$tgl_keluar' WHERE id=$id";
    mysqli_query($conn, $sql);
    header('Location: penghuni.php');
    exit;
}

// Ambil data penghuni
$penghuni = mysqli_query($conn, "SELECT * FROM tb_penghuni");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penghuni</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 800px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        input[type="text"], input[type="number"], input[type="date"] { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
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
    <h2>Data Penghuni</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php if(isset($_GET['edit'])) echo $_GET['edit']; ?>">
        Nama: <input type="text" name="nama" value="<?php if(isset($_GET['edit'])) { $id=$_GET['edit']; $q=mysqli_query($conn,"SELECT * FROM tb_penghuni WHERE id=$id"); $d=mysqli_fetch_assoc($q); echo $d['nama']; } ?>" required>
        No. KTP: <input type="text" name="no_ktp" value="<?php if(isset($d)) echo $d['no_ktp']; ?>" required>
        No. HP: <input type="text" name="no_hp" value="<?php if(isset($d)) echo $d['no_hp']; ?>" required>
        Tgl Masuk: <input type="date" name="tgl_masuk" value="<?php if(isset($d)) echo $d['tgl_masuk']; else echo date('Y-m-d'); ?>" required>
        Tgl Keluar: <input type="date" name="tgl_keluar" value="<?php if(isset($d)) echo $d['tgl_keluar']; ?>">
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($_GET['edit']) ? 'Update' : 'Tambah'; ?> Penghuni
        </button>
        <?php if(isset($_GET['edit'])): ?>
            <a href="penghuni.php" class="menu">Batal</a>
        <?php endif; ?>
    </form>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. KTP</th>
            <th>No. HP</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($row = mysqli_fetch_assoc($penghuni)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['no_ktp']); ?></td>
            <td><?= htmlspecialchars($row['no_hp']); ?></td>
            <td><?= htmlspecialchars($row['tgl_masuk']); ?></td>
            <td><?= htmlspecialchars($row['tgl_keluar']); ?></td>
            <td>
                <a href="penghuni.php?edit=<?= $row['id']; ?>" class="menu">Edit</a>
                <a href="penghuni.php?hapus=<?= $row['id']; ?>" class="menu" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 