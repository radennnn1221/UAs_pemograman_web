<?php
session_start();
require 'koneksi.php';

// Otentikasi dan pastikan keranjang tidak kosong
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer' || empty($_SESSION['keranjang'])) {
    header("Location: user.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$keranjang = $_SESSION['keranjang'];
$total_harga = 0;

// Hitung total harga sekali lagi untuk keamanan
foreach ($keranjang as $id_sepatu => $kuantitas) {
    $result = mysqli_query($koneksi, "SELECT harga FROM sepatu WHERE id_sepatu = $id_sepatu");
    $sepatu = mysqli_fetch_assoc($result);
    $total_harga += $sepatu['harga'] * $kuantitas;
}

// 1. Masukkan data ke tabel 'transaksi'
$status = "Menunggu Pembayaran";
mysqli_query($koneksi, "INSERT INTO transaksi (id_user, total_harga, status) VALUES ('$id_user', '$total_harga', '$status')");

// 2. Dapatkan ID transaksi terakhir
$id_transaksi_baru = mysqli_insert_id($koneksi);

// 3. Masukkan data ke tabel 'detail_transaksi' dan kurangi stok
foreach ($keranjang as $id_sepatu => $kuantitas) {
    $result = mysqli_query($koneksi, "SELECT harga FROM sepatu WHERE id_sepatu = $id_sepatu");
    $sepatu = mysqli_fetch_assoc($result);
    $harga_saat_transaksi = $sepatu['harga'];
    
    mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_sepatu, jumlah, harga_saat_transaksi) VALUES ('$id_transaksi_baru', '$id_sepatu', '$kuantitas', '$harga_saat_transaksi')");
    
    mysqli_query($koneksi, "UPDATE sepatu SET stok = stok - $kuantitas WHERE id_sepatu = $id_sepatu");
}

// 4. Kosongkan keranjang belanja
unset($_SESSION['keranjang']);

// Redirect ke halaman sukses
echo "<script>
        alert('Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        window.location.href = 'user.php';
      </script>";
exit;
?>