<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Admin</title>
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
        <li><a href="data_pelanggan.php">Data Pelanggan</a></li>
        <li class="active">Data Admin</li>
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </aside>
    <div class="main-content">
      <h2>Manajemen Data Admin</h2>
      <a href="tambah_admin.php" class="btn btn-primary">Tambah Admin</a>
      <table border="1" cellpadding="10">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Password</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM admin");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?= $row['id_admin']; ?></td>
            <td><?= $row['username']; ?></td>
            <td><?= $row['password']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td>
              <a href="edit_admin.php?id=<?= $row['id_admin']; ?>">Edit</a> |
              <a href="hapus_admin.php?id=<?= $row['id_admin']; ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?');">Hapus</a>
            </td>
          </tr>
         <?php } ?>
      </table>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>