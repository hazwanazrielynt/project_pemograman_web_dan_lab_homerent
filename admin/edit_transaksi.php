<?php
include 'koneksi.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM sewa WHERE id_sewa = '$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  echo "data transaksi tidak ditemukan!";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Transaksi</title>
  <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>
<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Edit Data Transaksi</h2>
      <form method="POST" class="form-add">

        <label>Status Pembayaran:</label><br>
        <select name="status_pembayaran" required>
          <option value="BELUM LUNAS" <?= ($data['status_pembayaran'] == 'BELUM LUNAS') ? 'selected' : ''; ?>>BELUM LUNAS</option>
          <option value="LUNAS" <?= ($data['status_pembayaran'] == 'LUNAS') ? 'selected' : ''; ?>>LUNAS</option>
        </select>
        <br><br>

        <div class="form-buttons">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>

      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['update'])) {

    $status_pembayaran = $_POST['status_pembayaran'];

    mysqli_query($conn, "
      UPDATE sewa SET
        status_pembayaran = '$status_pembayaran'
      WHERE id_sewa = '$id'
    ");

    header("Location: data_transaksi_admin.php");
    exit;
  }
  ?>
</body>
</html>
