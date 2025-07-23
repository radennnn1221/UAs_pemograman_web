<?php
session_start();

// Pastikan hanya customer yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    die("Akses ditolak.");
}

$id_sepatu = $_POST['id_sepatu'] ?? $_GET['id_sepatu'] ?? null;
$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Logika Tambah ke Keranjang
if ($aksi === 'tambah' && $id_sepatu) {
    if (isset($_SESSION['keranjang'][$id_sepatu])) {
        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        $_SESSION['keranjang'][$id_sepatu]++;
    } else {
        // Jika produk belum ada, tambahkan dengan jumlah 1
        $_SESSION['keranjang'][$id_sepatu] = 1;
    }
}

// Logika Hapus dari Keranjang
if ($aksi === 'hapus' && $id_sepatu) {
    if (isset($_SESSION['keranjang'][$id_sepatu])) {
        unset($_SESSION['keranjang'][$id_sepatu]);
    }
}

// Logika Update Kuantitas
if ($aksi === 'update') {
    foreach ($_POST['kuantitas'] as $id => $qty) {
        $jumlah = (int)$qty;
        if ($jumlah > 0) {
            $_SESSION['keranjang'][$id] = $jumlah;
        } else {
            // Jika kuantitas 0 atau kurang, hapus item
            unset($_SESSION['keranjang'][$id]);
        }
    }
}

// Redirect kembali ke halaman keranjang
header("Location: keranjang.php");
exit;
?>