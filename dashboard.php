<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
    header("Location: login_web.php");
    exit;
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];

// 2. PENGAMBILAN DATA DARI DATABASE
$total_sepatu_query = mysqli_query($koneksi, "SELECT COUNT(id_sepatu) as total FROM sepatu");
$total_sepatu = mysqli_fetch_assoc($total_sepatu_query)['total'];

$total_stok_query = mysqli_query($koneksi, "SELECT SUM(stok) as total FROM sepatu");
$total_stok = mysqli_fetch_assoc($total_stok_query)['total'] ?? 0;

$cards_data = [];
if ($role === 'admin') {
    $pendapatan_query = mysqli_query($koneksi, "SELECT SUM(total_harga) as total FROM transaksi WHERE status = 'Lunas'");
    $total_pendapatan = mysqli_fetch_assoc($pendapatan_query)['total'] ?? 0;
    // Dashboard untuk admin------
    $cards_data = [
        ["title" => "Total Jenis Sepatu", "value" => $total_sepatu, "image_url" => "foto/sepatu4.jpg"],
        ["title" => "Total Stok Tersedia", "value" => $total_stok, "image_url" => "foto/sepatu5.jpg"],
        ["title" => "Total Pendapatan", "value" => "Rp " . number_format($total_pendapatan), "image_url" => "foto/sepatu6.jpg"],
    ];
} else { // Petugas jangan lupa bos---------
    $pending_query = mysqli_query($koneksi, "SELECT COUNT(id_transaksi) as total FROM transaksi WHERE status = 'Menunggu Pembayaran'");
    $total_pending = mysqli_fetch_assoc($pending_query)['total'];

    $cards_data = [
        ["title" => "Total Jenis Sepatu", "value" => $total_sepatu, "image_url" => "foto/sepatu4.jpg"],
        ["title" => "Transaksi Menunggu", "value" => $total_pending, "image_url" => "foto/sepatu 2.jpg"],
        ["title" => "Total Stok Tersedia", "value" => $total_stok, "image_url" => "foto/sepatu5.jpg"],
    ];
}

// 3. VARIABEL UNTUK TAMPILAN
$page_title = "Dashboard - KenZo Store";
$logo_text = "Welcome to KenZo Store";
$main_headline = "Dashboard<br>" . ucfirst($role);
$main_description = "Selamat datang, " . htmlspecialchars($username) . "! Kelola toko melalui menu navigasi.";
$background_image_url = "foto/sepatu6.jpg";

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="style/style_administator.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .main-container {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo htmlspecialchars($background_image_url); ?>');
        }
    </style>
</head>

<body>
    <div class="main-container">
        <header>
            <div class="logo">
                <i class='bx bxs-dashboard'></i>
                <span><?php echo htmlspecialchars($logo_text); ?></span>
            </div>
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="active">HOME</a></li>
                    <li><a href="stok_sepatu.php">Manajemen Stok</a></li>

                    <?php if ($role === 'admin'): ?>
                        <li><a href="laporan_keuangan.php">Laporan Keuangan</a></li>
                        <li><a href="lihat_pesan.php">Pesan Customer</a></li>
                    <?php endif; ?>

                    <?php if ($role === 'petugas'): ?>
                        <li><a href="kelola_pembayaran.php">Kelola Pembayaran</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="header-icons">
                <i class='bx bx-search'></i>
                <a href="logout.php" class="logout-link" title="Logout">
                    <i class='bx bx-log-out-circle'></i>
                </a>
            </div>
        </header>
        <main>
            <div class="content-left">
                <h1><?php echo $main_headline; ?></h1>
                <p class="description"><?php echo $main_description; ?></p>
            </div>
            <div class="content-right">
                <div class="destination-cards">
                    <?php
                    $first = true;
                    foreach ($cards_data as $card) {
                        $card_class = $first ? 'card active' : 'card';
                        echo "<div class=\"$card_class\">";
                        echo '  <img src="' . htmlspecialchars($card['image_url']) . '" alt="' . htmlspecialchars($card['title']) . '">';
                        echo '  <div class="card-content">';
                        echo '      <p>' . htmlspecialchars($card['title']) . '</p>';
                        echo '      <h3>' . htmlspecialchars($card['value']) . '</h3>';
                        echo '  </div>';
                        echo '</div>';
                        $first = false;
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
    <script src="js/script_admin.js"></script>
</body>

</html>