<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Transaksi Admin</title>
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
        <li class="active">Data Transaksi</li>
        <li><a href="data_pelanggan.php">Data Pelanggan</a></li>
        <li><a href="data_admin.php">Data Admin</a></li>
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
      </ul>
    </aside>
    <div class="main-content">
      <h2>Manajemen Data Transaksi</h2>
      <a href="tambah_transaksi.php" class="btn btn-primary">Tambah Transaksi</a>
      <table border="1" cellpadding="10">
        <tr>
          <th>ID</th>
          <th>Nama Pelanggan</th>
          <th>Nama Admin</th>
          <th>Alamat Rumah yang Disewa</th>
          <th>Tanggal Sewa</th>
          <th>Tanggal Kembali</th>
          <th>Lama Sewa (Bulan)</th>
          <th>Metode Pembayaran</th>
          <th>Status Pembayaran</th>
          <th>Total Harga</th>
          <th>Aksi
          </th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT 
        s.id_sewa,
        p.nama as nama_pelanggan,
        a.nama as nama_admin,
        r.alamat,
        s.tanggal_sewa,
        s.tanggal_kembali,
        s.lama_sewa,
        s.metode_pembayaran,
        s.status_pembayaran,
        s.total_harga
    FROM sewa s
    JOIN pelanggan p ON s.id_pelanggan = p.id_pelanggan
    JOIN admin a ON s.id_admin = a.id_admin
    JOIN rumah r ON s.id_rumah = r.id_rumah
    order by s.id_sewa ASC
");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?= $row['id_sewa']; ?></td>
            <td><?= $row['nama_pelanggan']; ?></td>
            <td><?= $row['nama_admin']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['tanggal_sewa']; ?></td>
            <td><?= $row['tanggal_kembali']; ?></td>
            <td><?= $row['lama_sewa']; ?></td>
            <td><?= $row['metode_pembayaran']; ?></td>  
            <td>
              <?php if ($row['status_pembayaran'] == 'LUNAS') { ?>
                <span style="color:green;font-weight:bold;">LUNAS</span>
              <?php } else { ?>
                <span style="color:orange;font-weight:bold;">BELUM LUNAS</span>
              <?php } ?>
            </td>
            <td><?= number_format($row['total_harga'],0,',','.') ?></td>
            <td>
              <a href="edit_transaksi.php?id=<?= $row['id_sewa']; ?>">Edit</a> |
              <a href="hapus_transaksi.php?id=<?= $row['id_sewa']; ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?');">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>