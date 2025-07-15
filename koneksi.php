<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_kost'; // Pastikan nama database sesuai dengan yang Anda buat di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
?> 