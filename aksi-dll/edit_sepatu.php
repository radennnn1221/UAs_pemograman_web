<?php
session_start();
require 'koneksi.php';

// Otentikasi
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    header("Location: login_web.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM sepatu WHERE id_sepatu = $id");
$sepatu = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Edit Produk Sepatu</h1>
        <hr>
        <form action="aksi_sepatu.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="id_sepatu" value="<?php echo $sepatu['id_sepatu']; ?>">
            
            <div class="mb-3">
                <label for="nama_sepatu" class="form-label">Nama Sepatu</label>
                <input type="text" class="form-control" id="nama_sepatu" name="nama_sepatu" value="<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="merek" class="form-label">Merek</label>
                <input type="text" class="form-control" id="merek" name="merek" value="<?php echo htmlspecialchars($sepatu['merek']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $sepatu['harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $sepatu['stok']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="stok_sepatu.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>