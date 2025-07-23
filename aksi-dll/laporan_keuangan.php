<?php
session_start();
require 'koneksi.php';

// Otentikasi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_web.php");
    exit;
}

// Logika filter tanggal (tetap sama)
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$sql_where = "";
if (!empty($start_date) && !empty($end_date)) {
    $end_date_inclusive = date('Y-m-d', strtotime($end_date . ' +1 day'));
    $sql_where = " AND t.tanggal_transaksi BETWEEN '$start_date' AND '$end_date_inclusive'";
}

$query_transaksi = "SELECT t.*, u.nama_lengkap 
                    FROM transaksi t JOIN users u ON t.id_user = u.id_user 
                    WHERE t.status = 'Lunas'" . $sql_where . "
                    ORDER BY t.tanggal_transaksi DESC";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);

$query_pendapatan = "SELECT SUM(total_harga) as grand_total 
                     FROM transaksi t WHERE t.status = 'Lunas'" . $sql_where;
$result_pendapatan = mysqli_query($koneksi, $query_pendapatan);
$total_pendapatan = mysqli_fetch_assoc($result_pendapatan)['grand_total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Laporan Keuangan</h1>
        <hr>
        <div class="card mb-4">
            </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Aksi</th> </tr>
            </thead>
            <tbody>
                <?php while ($transaksi = mysqli_fetch_assoc($result_transaksi)): ?>
                <tr>
                    <td><?php echo $transaksi['id_transaksi']; ?></td>
                    <td><?php echo htmlspecialchars($transaksi['nama_lengkap']); ?></td>
                    <td><?php echo date('d M Y, H:i', strtotime($transaksi['tanggal_transaksi'])); ?></td>
                    <td class="text-end">Rp <?php echo number_format($transaksi['total_harga']); ?></td>
                    <td class="text-center">
                        <a href="aksi_admin.php?aksi=hapus_transaksi&id=<?php echo $transaksi['id_transaksi']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('PERINGATAN: Menghapus transaksi ini akan menghapus semua detail terkait dan bersifat permanen. Lanjutkan?');">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <th colspan="3" class="text-end">Total Pendapatan</th>
                    <th class="text-end" colspan="2">Rp <?php echo number_format($total_pendapatan); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>