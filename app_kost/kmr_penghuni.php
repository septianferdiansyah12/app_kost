<?php include 'navbar.php'; ?>
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relasi Kamar - Penghuni</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #eaf4ff; margin: 0; }
        .container { max-width: 900px; margin: 48px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(126,182,255,0.13); padding: 36px 32px 40px 32px; }
        h2 { color: #2d3e50; border-left: 5px solid #7eb6ff; padding-left: 12px; margin-top: 0; margin-bottom: 24px; font-size: 1.25em; }
        form { margin-bottom: 25px; }
        input[type="text"], input[type="number"], input[type="date"], select { padding: 8px; border: 1px solid #bfc9d9; border-radius: 5px; margin-right: 10px; }
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
            <a href="kmr_penghuni.php" class="menu">Batal</a>
        <?php endif; ?>
    </form>
    <table>
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
                <a href="kmr_penghuni.php?edit=<?= $row['id']; ?>" class="menu">Edit</a>
                <a href="kmr_penghuni.php?hapus=<?= $row['id']; ?>" class="menu" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="menu">Kembali ke Beranda</a>
</div>
</body>
</html> 