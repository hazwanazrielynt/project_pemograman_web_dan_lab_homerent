<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: login_user.php");
    exit;
}

$id_pelanggan = $_SESSION['pelanggan_id'];

// Ambil history transaksi user
$query = mysqli_query($conn, "
    SELECT s.id_sewa, r.foto_rumah, r.alamat, r.wilayah, s.tanggal_sewa, s.tanggal_kembali, s.lama_sewa, s.total_harga, s.metode_pembayaran, s.status_pembayaran
    FROM sewa s
    JOIN rumah r ON s.id_rumah = r.id_rumah
    WHERE s.id_pelanggan = '$id_pelanggan'
    ORDER BY s.id_sewa DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sewa_batamcenter.php">Sewa Rumah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="history.php">History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="main-content container mt-4">
  <h2 class="mb-4">History Transaksi Saya</h2>

  <div class="table-responsive">
    <table border="1" cellpadding="10">
        <tr>
          <th>No</th>
          <th>Alamat Rumah</th>
          <th>Wilayah</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Lama Sewa (Bulan)</th>
          <th>Total Harga</th>
          <th>Metode Pembayaran</th>
          <th>Status Pembayaran</th>
        </tr>
      <tbody class="text-center">
        <?php $no=1; while($row=mysqli_fetch_assoc($query)) { ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['alamat']; ?></td>
          <td><?= $row['wilayah']; ?></td>
          <td><?= $row['tanggal_sewa']; ?></td>
          <td><?= $row['tanggal_kembali']; ?></td>
          <td><?= $row['lama_sewa']; ?></td>
          <td>Rp <?= number_format($row['total_harga'],0,',','.'); ?></td>
          <td><?= $row['metode_pembayaran']; ?></td>
          <td>
            <?php if($row['status_pembayaran']=='LUNAS') { ?>
              <span class="text-success fw-bold">LUNAS</span>
            <?php } else { ?>
              <span class="text-warning fw-bold">BELUM LUNAS</span>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
