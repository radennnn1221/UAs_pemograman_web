<?php
session_start();
require 'koneksi.php';

// Otentikasi
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    die("Akses ditolak.");
}

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

// LOGIKA TAMBAH (CREATE)
if ($aksi == 'tambah') {
    $nama_sepatu = $_POST['nama_sepatu'];
    $merek = $_POST['merek'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Logika upload gambar
    $gambar = $_FILES['gambar']['name'];
    $lokasi = $_FILES['gambar']['tmp_name'];
    // PATH PENYIMPANAN GAMBAR SUDAH DIPERBAIKI
    move_uploaded_file($lokasi, 'foto/'.$gambar);

    $query = "INSERT INTO sepatu (nama_sepatu, merek, harga, stok, gambar) VALUES ('$nama_sepatu', '$merek', '$harga', '$stok', '$gambar')";
    mysqli_query($koneksi, $query);
} 
// LOGIKA EDIT (UPDATE)
else if ($aksi == 'edit') {
    $id_sepatu = $_POST['id_sepatu'];
    $nama_sepatu = $_POST['nama_sepatu'];
    $merek = $_POST['merek'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $lokasi = $_FILES['gambar']['tmp_name'];
        // PATH PENYIMPANAN GAMBAR SUDAH DIPERBAIKI
        move_uploaded_file($lokasi, 'foto/'.$gambar);
        $query = "UPDATE sepatu SET nama_sepatu='$nama_sepatu', merek='$merek', harga='$harga', stok='$stok', gambar='$gambar' WHERE id_sepatu=$id_sepatu";
    } else {
        // Jika tidak ada gambar baru, jangan update kolom gambar
        $query = "UPDATE sepatu SET nama_sepatu='$nama_sepatu', merek='$merek', harga='$harga', stok='$stok' WHERE id_sepatu=$id_sepatu";
    }
    mysqli_query($koneksi, $query);
} 
// LOGIKA HAPUS (DELETE)
else if ($aksi == 'hapus') {
    $id_sepatu = $_GET['id'];
    
    // Opsional: Hapus juga file gambar dari folder 'foto'
    // $data = mysqli_query($koneksi, "SELECT gambar FROM sepatu WHERE id_sepatu=$id_sepatu");
    // $sepatu = mysqli_fetch_assoc($data);
    // if (file_exists('foto/'.$sepatu['gambar'])) {
    //     unlink('foto/'.$sepatu['gambar']);
    // }

    $query = "DELETE FROM sepatu WHERE id_sepatu = $id_sepatu";
    mysqli_query($koneksi, $query);
}

// Redirect kembali ke halaman utama manajemen stok
header("Location: stok_sepatu.php");
exit;
?>