<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Rumah Admin</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="layout">
    <aside class="sidebar-left">
      <ul>
        <li ><a href="dashboard_admin.php">Dashboard Admin</a></li>
        <li class="active">Data Rumah</li>
        <li><a href="data_transaksi_admin.php">Data Transaksi</a></li>
        <li><a href="data_pelanggan.php">Data Pelanggan</a></li>
        <li><a href="data_admin.php">Data Admin</a></li>
        <li><a href="logout.php" class="logout">Logout</a></li>
      </ul>
    </aside>
    <div class="main-content">

      <h2>Manajemen Data Rumah</h2>
           <a href="tambah_rumah.php" class="btn btn-primary">Tambah Rumah</a>
      <table border="1" cellpadding="10">
          <tr>
              <th>ID</th>
              <th>Foto Rumah</th>
              <th>Wilayah</th>
              <th>Alamat</th>
              <th>Harga Sewa</th>
              <th>Status</th>
              <th>Aksi</th>
          </tr>
          <?php
          $result = mysqli_query($conn, "SELECT * FROM rumah");
          while($row = mysqli_fetch_assoc($result)){
          ?>
              <tr>
                  <td><?= $row['id_rumah']; ?></td>
                  <td><img src="uploads/<?= $row['foto_rumah']; ?>" alt="Foto Rumah" style="width:200px; height:auto;"></td>
                  <td><?= $row['wilayah']; ?></td>
                  <td><?= $row['alamat']; ?></td>
                  <td><?= $row['harga_sewa']; ?></td>
                  <td><?= $row['status']; ?></td>
                  <td>
                      <a href="edit_rumah.php?id=<?= $row['id_rumah']; ?>">Edit</a> |
                      <a href="hapus_rumah.php?id=<?= $row['id_rumah']; ?>">Hapus</a>
                  </td>
              </tr>
          <?php } ?>
      </table>
    </div>
  </div>
</body>

