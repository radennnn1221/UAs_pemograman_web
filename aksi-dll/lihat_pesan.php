<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan hanya ADMIN yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_web.php");
    exit;
}

$query = "SELECT p.*, u.nama_lengkap 
          FROM pesan_kesan p 
          JOIN users u ON p.id_user = u.id_user 
          ORDER BY p.tanggal_kirim DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Pesan & Kesan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Daftar Pesan & Kesan Customer</h1>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Isi Pesan</th>
                        <th>Tanggal Kirim</th>
                        <th>Aksi</th> </tr>
                </thead>
                <tbody>
                    <?php while ($pesan = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pesan['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($pesan['subjek']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($pesan['isi_pesan'])); ?></td>
                        <td><?php echo date('d M Y, H:i', strtotime($pesan['tanggal_kirim'])); ?></td>
                        <td class="text-center">
                            <a href="aksi_admin.php?aksi=hapus_pesan&id=<?php echo $pesan['id_pesan']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini secara permanen?');">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>