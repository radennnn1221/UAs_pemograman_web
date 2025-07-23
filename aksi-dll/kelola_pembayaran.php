<?php
session_start();
require 'koneksi.php';

// Otentikasi Petugas
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['petugas', 'admin'])) { // Admin juga bisa lihat
    header("Location: login_web.php");
    exit;
}

$query = "SELECT transaksi.*, users.nama_lengkap 
          FROM transaksi 
          JOIN users ON transaksi.id_user = users.id_user 
          ORDER BY tanggal_transaksi DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Daftar Transaksi Masuk</h1>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($transaksi = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $transaksi['id_transaksi']; ?></td>
                    <td><?php echo htmlspecialchars($transaksi['nama_lengkap']); ?></td>
                    <td><?php echo date('d M Y, H:i', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                    <td>Rp <?php echo number_format($transaksi['total_harga']); ?></td>
                    <td>
                        <?php 
                            $status = $transaksi['status'];
                            $badge_class = ($status == 'Lunas') ? 'bg-success' : 'bg-warning';
                            echo "<span class='badge $badge_class'>$status</span>";
                        ?>
                    </td>
                    <td>
                        <?php if ($status !== 'Lunas'): ?>
                            <a href="aksi_pembayaran.php?id=<?php echo $transaksi['id_transaksi']; ?>" class="btn btn-sm btn-success mb-1" onclick="return confirm('Konfirmasi pembayaran untuk transaksi ini?');">
                                Konfirmasi
                            </a>
                        <?php endif; ?>
                        
                        <a href="aksi_petugas.php?aksi=hapus_transaksi&id=<?php echo $transaksi['id_transaksi']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('PERINGATAN: Anda akan menghapus transaksi ini secara permanen. Lanjutkan?');">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>