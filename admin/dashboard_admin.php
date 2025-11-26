<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
?>

<?php
include 'koneksi.php';

$query_batam_center = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batam Center'");
$data_batam_center = mysqli_fetch_assoc($query_batam_center);

$query_lubuk_baja = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Lubuk Baja'");
$data_lubuk_baja = mysqli_fetch_assoc($query_lubuk_baja);

$query_batu_aji = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batu Aji'");
$data_batu_aji = mysqli_fetch_assoc($query_batu_aji);

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
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
    Navigasi Admin
  </a>
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
        <li class="active">Dashboard Admin </li>
        <li><a href="data_rumah_admin.php">Data Rumah</a></li>
        <li><a href="data_transaksi_admin.php">Data Transaksi</a></li>
        <li><a href="data_pelanggan.php">Data Pelanggan</a></li>
        <li><a href="data_admin.php">Data Admin</a></li>
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <div class="header">
        <h2><?php echo "Selamat Datang, " . ($_SESSION['nama'] ?? ''); ?></h2>
        <div class="datetime" id="datetime">
          <?php
          date_default_timezone_set('Asia/Jakarta'); 
          $datetime = new DateTime(); 
          $day = $datetime->format('l');    
          $date = $datetime->format('d');   
          $month = $datetime->format('F');  
          $year = $datetime->format('Y');   

          echo "$day, $date $month $year";
          ?>
        </div>
      </div>
      <section class="content-box">
        <h2>Kata-Kata Hari ini Untuk Admin</h2>
        <p>
          Disemangati oleh orang yang bikin semangat hancur
        </p>

        <h3>Wilayah Rumah Yang Tersedia Untuk Disewa</h3>
        <div class="motor-grid">
          <div class="motor-card">
          <p>BATAM CENTER</p>
            <span><?= $data_batam_center['total']; ?></span>
          </div>
          <div class="motor-card">
            <p>LUBUK BAJA</p>
            <span><?= $data_lubuk_baja['total']; ?></span>
          </div>
          <div class="motor-card">
            <p>BATU AJI</p>
            <span><?= $data_batu_aji['total']; ?></span>
          </div>
        </div>
      </section>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
