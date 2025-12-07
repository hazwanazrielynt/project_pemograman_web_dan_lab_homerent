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
    <div class="content-box" style="max-width: 520px; text-align:center;">

      <h2 class="mb-3">Pembayaran QRIS</h2>
      <p class="mb-4 text-muted">Silakan scan QR untuk menyelesaikan pembayaran</p>
      <div style="margin: 20px 0;">
        <img 
          src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=http://192.168.1.8/Lab/admin/bayar.php?id_sewa=<?= $id ?>" 
          style="
            width:260px; 
            border-radius:16px; 
            box-shadow:0 6px 20px rgba(0,0,0,0.15);
          "
        >
      </div>
      <p style="font-size:16px;">
        Total Bayar:
        <br>
        <span style="font-size:20px; color:#1E90FF; font-weight:bold;">
          Rp <?= number_format($data['total_harga'], 0, ',', '.') ?>
        </span>
      </p>
      <p style="margin-top:10px;">
        Status Pembayaran:
        <br>
        <span 
          id="status"
          style="
            display:inline-block;
            margin-top:5px;
            padding:6px 16px;
            border-radius:20px;
            background:#FFE082;
            font-weight:bold;
          ">
          <?= $data['status_pembayaran']; ?>
        </span>
      </p>
      <button class="btn w-100 mt-4" onclick="window.location.href='history.php'">Selesai</button>
    </div>
  </div>
<script>
setInterval(() => {
  fetch("/Lab/admin/cek_status.php?id_sewa=<?= $id ?>")
    .then(r => r.text())
    .then(d => document.getElementById("status").innerHTML = d)
}, 2000);
</script>

</body>