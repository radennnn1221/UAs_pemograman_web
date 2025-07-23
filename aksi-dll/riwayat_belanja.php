<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan hanya customer yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login_web.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil semua data transaksi milik user yang sedang login, urutkan dari yang terbaru
$stmt = $koneksi->prepare("SELECT * FROM transaksi WHERE id_user = ? ORDER BY tanggal_transaksi DESC");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Belanja - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Riwayat Belanja Anda</h1>
            <a href="user.php" class="btn btn-secondary">Kembali ke Toko</a>
        </div>
        <hr>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info text-center">Anda belum memiliki riwayat transaksi.</div>
        <?php else: ?>
            <div class="list-group">
                <?php while ($transaksi = $result->fetch_assoc()): ?>
                    <div class="list-group-item list-group-item-action flex-column align-items-start mb-3 border rounded">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Transaksi #<?php echo $transaksi['id_transaksi']; ?></h5>
                            <small><?php echo date('d M Y, H:i', strtotime($transaksi['tanggal_transaksi'])); ?></small>
                        </div>
                        <p class="mb-1">Total Belanja: <strong>Rp <?php echo number_format($transaksi['total_harga']); ?></strong></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <?php 
                                $status = $transaksi['status'];
                                $badge_class = ($status == 'Lunas') ? 'bg-success' : 'bg-warning text-dark';
                                echo "<span class='badge $badge_class'>$status</span>";
                            ?>
                            <a href="detail_transaksi.php?id=<?php echo $transaksi['id_transaksi']; ?>" class="btn btn-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>