<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pelanggan</title>
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
        <li><a href="dashboard_admin.php">Dashboard Admin</a></li>
        <li><a href="data_rumah_admin.php">Data Rumah</a></li>
        <li><a href="data_transaksi_admin.php">Data Transaksi</a></li>
        <li class="active">Data Pelanggan</li>
        <li><a href="data_admin.php">Data Admin</a></li>
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </aside>
    <div class="main-content">
      <h2>Manajemen Data Pelanggan</h2>
      <a href="tambah_pelanggan.php" class="btn btn-primary">Tambah Pelanggan</a>
      <table border="1" cellpadding="10">
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Domisili</th>
          <th>Nomor Telepon</th>
          <th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM pelanggan");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?= $row['id_pelanggan']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['domisili']; ?></td>
            <td><?= $row['no_hp']; ?></td>
            <td>
              <a href="edit_pelanggan.php?id=<?= $row['id_pelanggan']; ?>">Edit</a> |
              <a href="hapus_pelanggan.php?id=<?= $row['id_pelanggan']; ?>">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>