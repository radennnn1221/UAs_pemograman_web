<?php
session_start();
require 'koneksi.php';

// Otentikasi
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'petugas')) {
    header("Location: login_web.php");
    exit;
}

$result = mysqli_query($koneksi, "SELECT * FROM sepatu ORDER BY id_sepatu DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Stok Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Manajemen Stok Sepatu</h1>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        <hr>
        <a href="tambah_sepatu.php" class="btn btn-primary mb-3">➕ Tambah Sepatu Baru</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Sepatu</th>
                    <th>Merek</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($sepatu = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $sepatu['id_sepatu']; ?></td>
                    <td><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></td>
                    <td><?php echo htmlspecialchars($sepatu['merek']); ?></td>
                    <td>Rp <?php echo number_format($sepatu['harga']); ?></td>
                    <td><?php echo $sepatu['stok']; ?></td>
                    <td>
                        <a href="edit_sepatu.php?id=<?php echo $sepatu['id_sepatu']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="aksi_sepatu.php?aksi=hapus&id=<?php echo $sepatu['id_sepatu']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>