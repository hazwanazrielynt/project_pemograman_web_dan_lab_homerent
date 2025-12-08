<?php
include 'koneksi.php';
$id = $_GET['id_sewa'];

if (isset($_POST['bayar'])) {
  mysqli_query($conn, "
    UPDATE sewa 
    SET status_pembayaran='LUNAS' 
    WHERE id_sewa='$id'
  ");
  echo "HOREEEE!! Pembayaran Berhasil";
}
?>

<form method="post">
  <button name="bayar" style="width: 100px;">BAYAR SEKARANG</button>
</form>
