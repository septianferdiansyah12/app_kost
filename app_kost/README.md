# Aplikasi Manajemen Kost (PHP Native)

Aplikasi web ini digunakan untuk mengelola data kost (boarding house) seperti kamar, penghuni, barang, tagihan, dan pembayaran. Dibuat menggunakan PHP Native dan MySQL, dengan tampilan modern dan navigasi yang mudah.

## Fitur Utama
- **Dashboard:** Ringkasan kamar, penghuni, tagihan, dan pembayaran.
- **Manajemen Kamar:** Tambah, edit, hapus, dan lihat data kamar.
- **Manajemen Penghuni:** Tambah, edit, hapus, dan lihat data penghuni.
- **Manajemen Barang:** Data inventaris barang kost.
- **Relasi Kamar-Penghuni:** Atur penghuni yang menempati kamar.
- **Barang Bawaan Penghuni:** Catat barang milik penghuni.
- **Tagihan & Pembayaran:** Kelola tagihan bulanan dan pembayaran penghuni.
- **Tampilan Modern:** Menggunakan tema biru soft dan navigasi navbar di semua halaman.

## Struktur Folder
```
app_kost/
├── index.php           # Halaman utama (landing page)
├── dashboard.php       # Dashboard ringkasan
├── navbar.php          # Navigasi utama
├── koneksi.php         # Koneksi database
├── kamar.php           # CRUD kamar
├── penghuni.php        # CRUD penghuni
├── barang.php          # CRUD barang
├── kmr_penghuni.php    # Relasi kamar-penghuni
├── brng_bawaan.php     # Barang bawaan penghuni
├── tagihan.php         # CRUD tagihan
├── bayar.php           # CRUD pembayaran
├── README.md           # Dokumentasi aplikasi
└── kost.sql            # Struktur database (import ke phpMyAdmin)
```

## Cara Instalasi & Menjalankan
1. **Clone/copy** folder `app_kost` ke dalam folder `htdocs` XAMPP.
2. **Import database:**
   - Buka `phpMyAdmin`.
   - Buat database baru dengan nama `db_kost`.
   - Import file `kost.sql` ke database tersebut.
3. **Konfigurasi koneksi:**
   - Pastikan file `koneksi.php` sudah sesuai dengan user/password MySQL Anda.
4. **Jalankan aplikasi:**
   - Buka browser dan akses `http://localhost/app_kost/index.php`

## Catatan
- Pastikan Apache & MySQL di XAMPP sudah berjalan.
- Jika ada error, aktifkan error reporting di file PHP untuk debugging.
- Untuk menambah data awal, bisa gunakan fitur tambah di masing-masing menu atau import data contoh ke database.

---

Aplikasi ini dibuat tanpa framework, hanya PHP Native dan MySQL, agar mudah dipelajari dan dikembangkan. 