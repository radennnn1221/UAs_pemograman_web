<?php
session_start();
// Otentikasi
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    header("Location: login_web.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Tambah Produk Sepatu Baru</h1>
        <hr>
        <form action="aksi_sepatu.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="tambah">
            <div class="mb-3">
                <label for="nama_sepatu" class="form-label">Nama Sepatu</label>
                <input type="text" class="form-control" id="nama_sepatu" name="nama_sepatu" required>
            </div>
            <div class="mb-3">
                <label for="merek" class="form-label">Merek</label>
                <input type="text" class="form-control" id="merek" name="merek" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="stok_sepatu.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>