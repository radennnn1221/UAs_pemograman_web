### 👟 **Aplikasi Web Toko Sepatu (KenZo Store)**

Aplikasi e-commerce sederhana yang dibangun menggunakan PHP Native dengan sistem manajemen multi-peran (Admin, Petugas, dan Customer). Proyek ini mencakup fungsionalitas penuh mulai dari manajemen stok, proses transaksi, hingga pelaporan.

### 🌐 Demo Online

Aplikasi ini sudah di-hosting dan dapat diakses melalui link berikut:
**(http://kenzoo-store.my.id/toko_sepatu/login_web.php))**

###  !Fitur Utama

#### **✅ Admin**

  * Dashboard dengan statistik pendapatan dan ringkasan data.
  * Manajemen penuh data produk sepatu (Tambah, Edit, Hapus).
  * Melihat dan menghapus semua pesan & tanggapan dari customer.
  * Melihat dan menghapus laporan keuangan (transaksi yang sudah lunas).

#### **✅ Petugas**

  * Dashboard dengan statistik relevan seperti transaksi yang menunggu pembayaran.
  * Manajemen penuh data produk sepatu (Tambah, Edit, Hapus).
  * Mengelola transaksi dari customer (konfirmasi pembayaran, menghapus transaksi).

#### **✅ Customer**

  * Sistem registrasi dan login yang aman.
  * Galeri produk dengan filter berdasarkan kategori (merek).
  * Keranjang belanja fungsional (tambah, update kuantitas, hapus item).
  * Proses checkout untuk menyelesaikan pesanan.
  * Halaman riwayat belanja untuk melihat transaksi sebelumnya.
  * Fitur untuk mengirim pesan atau tanggapan kepada admin.

### 🛠️ Teknologi yang Digunakan

  * **Backend**: **PHP Native** (prosedural & struktural)
  * **Database**: **MySQL** (dikelola via phpMyAdmin)
  * **Frontend**: **HTML**, **CSS**, **Bootstrap 5**

### 🚀 Cara Menjalankan (Localhost)

1.  Salin semua file dan folder proyek ke dalam direktori `htdocs` di dalam instalasi **XAMPP** Anda (misal: `C:\xampp\htdocs\toko_sepatu`).
2.  Jalankan **XAMPP Control Panel**, lalu start modul **Apache** dan **MySQL**.
3.  Buka browser dan pergi ke `http://localhost/phpmyadmin`.
4.  Buat database baru dengan nama `toko_sepatu_db`.
5.  Masuk ke database yang baru dibuat, klik tab **"Import"**, dan pilih file `.sql` yang berisi struktur dan data awal.
6.  Pastikan file `koneksi.php` sudah sesuai dengan pengaturan database lokal Anda (`user: root`, `password: ""`).
7.  Buka browser dan akses proyek melalui `http://localhost/toko_sepatu`.
