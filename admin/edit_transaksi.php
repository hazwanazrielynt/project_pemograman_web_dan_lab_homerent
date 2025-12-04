<?php
include 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM sewa WHERE id_sewa = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Transaksi</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Edit Data Transaksi</h2>
      <form method="POST" class="form-add">

        <label>Nama Pelanggan:</label><br>
        <input type="text" name="nama_pelanggan" value="<?= $data['nama_pelanggan']; ?>" required><br><br>

        <label>Nama Admin:</label><br>
        <input type="text" name="nama_admin" value="<?= $data['nama_admin']; ?>" required><br><br>

        <label>Nama Rumah:</label><br>
        <input type="text" name="nama_rumah" value="<?= $data['nama_rumah']; ?>" required><br><br>

        <label>Tanggal Sewa:</label><br>
        <input type="date" name="tanggal_sewa" value="<?= $data['tanggal_sewa']; ?>" required><br><br>

        <label>Tanggal Kembali:</label><br>
        <input type="date" name="tanggal_kembali" value="<?= $data['tanggal_kembali']; ?>" required><br><br>

        <div class="form-buttons">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['update'])) {
    $nama_rumah = $_POST['nama_rumah'];
    $wilayah = $_POST['wilayah'];
    $alamat = $_POST['alamat'];
    $harga_sewa = $_POST['harga_sewa'];
    $status = $_POST['status'];
    $query = "UPDATE rumah SET
              nama_rumah = '$nama_rumah',
              wilayah = '$wilayah',
              alamat = '$alamat',
              harga_sewa = '$harga_sewa',
              status = '$status'
              WHERE id_rumah = $id";
    mysqli_query($conn, $query);
    header("Location: data_transaksi_admin.php");
    exit;
  }
  ?>
</body>

</html>