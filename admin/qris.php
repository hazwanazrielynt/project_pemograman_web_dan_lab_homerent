<?php
include 'koneksi.php';

if (!isset($_GET['id_sewa'])) {
    die("ID Sewa tidak ditemukan!");
}

$id = $_GET['id_sewa'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT total_harga, status_pembayaran 
  FROM sewa 
  WHERE id_sewa='$id'
"));

if (!$data) {
    die("Data tidak ditemukan di database!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran QRIS</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="main-content">
  <div class="content-box">
    <h2 class="mb-3 text-center">Pembayaran QRIS</h2>
    <p class="text-center">Silakan Scan QR untuk Pembayaran</p>
    <div style="text-align:center; margin:20px 0;">
      <img 
        src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=http://192.168.206.1/Lab/admin/bayar.php?id_sewa=<?= $id ?>"
        style="max-width:300px;"
      >
    </div>
    <p class="text-center" style="font-size:18px;">
      Total Bayar:
      <b>Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></b>
    </p>
    <p class="text-center" style="font-size:18px;">
      Status:
      <b>
        <span id="status"><?= $data['status_pembayaran']; ?></span>
      </b>
    </p>
    <div class="form-buttons" style="justify-content:center; margin-top:25px;">
      <button type="button" class="btn btn-danger" onclick="window.location.href='data_transaksi_admin.php'">Kembali ke Data Transaksi</button>
    </div>
  </div>
</div>
</body>
<script>
setInterval(() => {
  fetch("/Lab/admin/cek_status.php?id_sewa=<?= $id ?>")
    .then(r => r.text())
    .then(d => document.getElementById("status").innerHTML = d)
}, 2000);
</script>
</html>
