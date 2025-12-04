<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$data_batam_center = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batam Center'"));
$data_lubuk_baja  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Lubuk Baja'"));
$data_batu_aji    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batu Aji'"));

$data_harian = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM sewa
    WHERE DATE(tanggal_transaksi) = CURDATE()
"));

$data_bulanan = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM sewa
    WHERE MONTH(tanggal_sewa) = MONTH(CURDATE())
    AND YEAR(tanggal_sewa) = YEAR(CURDATE())
"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <li class="nav-item dropdown d-lg-none">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Navigasi Admin</a>
        <ul class="dropdown-menu text-center">
            <li><a class="dropdown-item" href="dashboard_admin.php">Dashboard Admin</a></li>
            <li><a class="dropdown-item" href="data_rumah_admin.php">Data Rumah</a></li>
            <li><a class="dropdown-item" href="data_transaksi_admin.php">Data Transaksi</a></li>
            <li><a class="dropdown-item" href="data_pelanggan.php">Data Pelanggan</a></li>
            <li><a class="dropdown-item" href="data_admin.php">Data Admin</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </li>

    <div class="layout">
        <aside class="sidebar-left">
            <ul>
                <li class="active">Dashboard Admin</li>
                <li><a href="data_rumah_admin.php">Data Rumah</a></li>
                <li><a href="data_transaksi_admin.php">Data Transaksi</a></li>
                <li><a href="data_pelanggan.php">Data Pelanggan</a></li>
                <li><a href="data_admin.php">Data Admin</a></li>
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">

            <!-- Header -->
            <div class="header">
                <h2><?php echo "Selamat Datang, " . ($_SESSION['nama'] ?? ''); ?></h2>
                <div class="datetime">
                    <?php
                    date_default_timezone_set('Asia/Jakarta');
                    echo date("l, d F Y");
                    ?>
                </div>
            </div>
            <section class="content-box">

                <h2>Kata-Kata Hari ini Untuk Admin</h2>
                <p>Semangat Hari Ini UAS, Semoga Nilai A Untuk Semua Admin!</p>

                <h3>Wilayah Rumah Yang Tersedia Untuk Disewa</h3>
                <div class="motor-grid">
                    <div class="motor-card">
                        <p>BATAM CENTER</p><span><?= $data_batam_center['total']; ?></span>
                    </div>
                    <div class="motor-card">
                        <p>LUBUK BAJA</p><span><?= $data_lubuk_baja['total']; ?></span>
                    </div>
                    <div class="motor-card">
                        <p>BATU AJI</p><span><?= $data_batu_aji['total']; ?></span>
                    </div>
                </div>

                <?php
                $year = date("Y");
                $month = date("n");
                $today = date("j");

                $monthNames = [
                    1 => "Januari",
                    2 => "Februari",
                    3 => "Maret",
                    4 => "April",
                    5 => "Mei",
                    6 => "Juni",
                    7 => "Juli",
                    8 => "Agustus",
                    9 => "September",
                    10 => "Oktober",
                    11 => "November",
                    12 => "Desember"
                ];

                $dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDay = date("w", strtotime("$year-$month-1"));
                ?>
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card p-3 calendar-card">
                            <h4>Kalender</h4>
                            <h5 class="text-center"><?= $monthNames[$month] . " " . $year; ?></h5>

                            <div class="bootstrap-calendar">
                                <?php foreach ($dayNames as $d): ?>
                                    <div class="day-name"><?= $d ?></div>
                                <?php endforeach; ?>

                                <?php for ($i = 0; $i < $firstDay; $i++): ?>
                                    <div></div>
                                <?php endfor; ?>

                                <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                                    <div class="<?= ($d == $today) ? 'today' : 'day'; ?>"><?= $d ?></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="card p-3 mb-3 text-center stat-card">
                            <h5>Sewa Hari Ini</h5>
                            <h2 class="text-primary fw-bold"><?= $data_harian['total']; ?></h2>
                        </div>

                        <div class="card p-3 text-center stat-card">
                            <h5>Sewa Bulan Ini</h5>
                            <h2 class="text-success fw-bold"><?= $data_bulanan['total']; ?></h2>
                        </div>

                    </div>

                </div>

            </section>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>