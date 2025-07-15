<?php
// navbar.php
?>
<style>
.navbar {
    background: #4f8cff;
    padding: 0 0 0 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 56px;
}
.navbar .brand {
    color: #fff;
    font-size: 1.3em;
    font-weight: bold;
    padding: 0 24px;
    letter-spacing: 1px;
    text-decoration: none;
}
.navbar .nav {
    display: flex;
    align-items: center;
    gap: 0.5em;
}
.navbar .nav a {
    color: #fff;
    text-decoration: none;
    padding: 0 16px;
    height: 56px;
    display: flex;
    align-items: center;
    transition: background 0.2s;
    font-weight: 500;
}
.navbar .nav a:hover, .navbar .nav a.active {
    background: #2d3e50;
}
@media (max-width: 700px) {
    .navbar { flex-direction: column; height: auto; }
    .navbar .brand { padding: 10px 0; }
    .navbar .nav { flex-wrap: wrap; justify-content: center; }
    .navbar .nav a { padding: 8px 10px; height: auto; }
}
</style>
<div class="navbar">
    <a href="dashboard.php" class="brand">KostApp</a>
    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Beranda</a>
        <a href="kamar.php">Kamar</a>
        <a href="penghuni.php">Penghuni</a>
        <a href="barang.php">Barang</a>
        <a href="kmr_penghuni.php">Relasi Kamar</a>
        <a href="brng_bawaan.php">Barang Bawaan</a>
        <a href="tagihan.php">Tagihan</a>
        <a href="bayar.php">Pembayaran</a>
    </div>
</div> 