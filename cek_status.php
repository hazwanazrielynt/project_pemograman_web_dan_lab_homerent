<?php
include 'koneksi.php';

$id = $_GET['id_sewa'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT status_pembayaran FROM sewa WHERE id_sewa='$id'
"));

echo $data['status_pembayaran'];
