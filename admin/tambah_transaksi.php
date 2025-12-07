<?php
session_start(); 
include 'koneksi.php';

if (!isset($_SESSION['admin_id'])) {
  header("Location: login_admin.php");
  exit;
}

if (isset($_GET['wilayah'])) {
  $wilayah = $_GET['wilayah'];
  $query = mysqli_query($conn, "SELECT * FROM rumah WHERE wilayah = '$wilayah'");

  echo "<option value=''>-- Pilih Rumah --</option>";
  while ($r = mysqli_fetch_assoc($query)) {
    echo "<option value='" . $r['id_rumah'] . "'>";
    echo $r['alamat'] . " (Rp " . number_format($r['harga_sewa'], 0, ',', '.') . ")";
    echo "</option>";
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Transaksi</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
<div class="main-content">
  <div class="content-box">
    <h2>Tambah Data Transaksi</h2>

    <form method="POST" class="form-add">
      <label>Nama:</label>
      <input type="text" name="nama" required>

      <label>No HP:</label>
      <input type="text" name="no_hp" required>

      <label>Domisili:</label>
      <input type="text" name="domisili" required>

      <label>Wilayah:</label>
      <select id="wilayah" required>
        <option value="">-- Pilih Wilayah --</option>
        <option value="Batam Center">Batam Center</option>
        <option value="Lubuk Baja">Lubuk Baja</option>
        <option value="Batu Aji">Batu Aji</option>
      </select>

      <label>Rumah:</label>
      <select name="id_rumah" id="rumah" required>
        <option value="">-- Pilih Rumah --</option>
      </select>

      <label>Tanggal Sewa:</label>
      <input type="date" name="tanggal_sewa" required>

      <label>Lama Sewa (bulan)</label>
      <select name="lama_sewa" required>
        <option value="">-- Pilih Lama Sewa --</option>
        <option value="1">1 Bulan</option>
        <option value="2">2 Bulan</option>
        <option value="3">3 Bulan</option>
        <option value="4">4 Bulan</option>
      </select>

      <label>Metode Pembayaran:</label>
      <select name="metode_pembayaran" required>
        <option value="Tunai">Tunai</option>
        <option value="QRIS">QRIS</option>
      </select>

      <div class="form-buttons">
        <button type="submit"  class="btn btn-primary" name="simpan">Simpan</button>
        <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
      </div>
    </form>
  </div>
</div>

<?php
if (isset($_POST['simpan'])) {

  $nama       = $_POST['nama'];
  $no_hp      = $_POST['no_hp'];
  $domisili   = $_POST['domisili'];
  $id_rumah   = $_POST['id_rumah'];
  $tgl_sewa   = $_POST['tanggal_sewa'];
  $lama_bulan = (int)$_POST['lama_sewa'];
  $metode     = $_POST['metode_pembayaran'];
  $id_admin   = $_SESSION['admin_id'];

  // Ambil harga rumah
  $q = mysqli_query($conn, "SELECT harga_sewa FROM rumah WHERE id_rumah='$id_rumah'");
  $data = mysqli_fetch_assoc($q);
  $harga = $data['harga_sewa'];

  // Hitung checkout otomatis
  $checkout_date = (new DateTime($tgl_sewa))->modify("+$lama_bulan month");
  $tgl_kembali = $checkout_date->format('Y-m-d');

  // Hitung total harga
  $total = $harga * $lama_bulan;

  // Tambah data pelanggan baru
  $username = strtolower(str_replace(' ', '', $nama));
  $password = "admin123";
  mysqli_query($conn, "INSERT INTO pelanggan (username,password,nama,domisili,no_hp)
    VALUES ('$username','$password','$nama','$domisili','$no_hp')");
  $id_pelanggan = mysqli_insert_id($conn);

  // Tambah data sewa
  $insert = mysqli_query($conn, "
    INSERT INTO sewa 
    (id_pelanggan, id_admin, id_rumah, tanggal_sewa, tanggal_kembali, total_harga, metode_pembayaran)
    VALUES 
    ('$id_pelanggan','$id_admin','$id_rumah','$tgl_sewa','$tgl_kembali','$total','$metode')
  ");

  if ($insert) {
    $last_id = mysqli_insert_id($conn);
    if ($metode == 'QRIS') {
      header("Location: /Lab/admin/qris.php?id_sewa=$last_id");
    } else {
      header("Location: data_transaksi_admin.php");
    }
    exit;
  } else {
    echo "Gagal: " . mysqli_error($conn);
  }
}
?>

</body>
<script>
document.getElementById('wilayah').addEventListener('change', function() {
  var wilayah = this.value;
  var rumahSelect = document.getElementById('rumah');

  if (wilayah !== "") {
    fetch("tambah_transaksi.php?wilayah=" + wilayah)
      .then(response => response.text())
      .then(data => {
        rumahSelect.innerHTML = data;
      });
  } else {
    rumahSelect.innerHTML = "<option value=''>-- Pilih Rumah --</option>";
  }
});
</script>
</html>
