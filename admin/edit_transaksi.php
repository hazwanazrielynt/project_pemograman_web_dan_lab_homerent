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
        <label>Tanggal Sewa:</label><br>
        <input type="date" name="tanggal_sewa" value="<?= $data['tanggal_sewa']; ?>" required>
        <br><br>
        <label>Tanggal Kembali:</label><br>
        <input type="date" name="tanggal_kembali" value="<?= $data['tanggal_kembali']; ?>" required>
        <br><br>
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

    $tanggal_sewa       = $_POST['tanggal_sewa'];
    $tanggal_kembali    = $_POST['tanggal_kembali'];
    $status_pembayaran  = $_POST['status_pembayaran'];

    $getRumah = mysqli_query($conn, "
      SELECT rumah.harga_sewa 
      FROM sewa 
      JOIN rumah ON sewa.id_rumah = rumah.id_rumah 
      WHERE sewa.id_sewa = '$id'
    ");

    $dataRumah = mysqli_fetch_assoc($getRumah);
    $harga_per_malam = $dataRumah['harga_sewa'];

    $malam = (strtotime($tanggal_kembali) - strtotime($tanggal_sewa)) / 86400;
    if ($malam < 1) {
      $malam = 1;
    }

    $total_harga = $malam * $harga_per_malam;

    mysqli_query($conn, "
      UPDATE sewa SET
        tanggal_sewa = '$tanggal_sewa',
        tanggal_kembali = '$tanggal_kembali',
        total_harga = '$total_harga',
        status_pembayaran = '$status_pembayaran'
      WHERE id_sewa = '$id'
    ");

    header("Location: data_transaksi_admin.php");
    exit;
  }
  ?>
</body>
</html>
