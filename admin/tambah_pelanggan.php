<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pelanggan</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Tambah Data Pelanggan</h2>
      <form method="POST" class="form-add">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>
        <label>Domisili:</label><br>
        <input type="text" name="domisili" required><br><br>
        <label>Nomor Telepon:</label><br>
        <input type="text" name="no_hp" required><br><br>
        <div class="form-buttons">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $domisili = $_POST['domisili'];
    $no_hp = $_POST['no_hp'];
    $query = "INSERT INTO pelanggan (nama, domisili, no_hp)
              VALUES ('$nama', '$domisili', '$no_hp')";
    mysqli_query($conn, $query);
    header("Location: data_pelanggan.php");
    exit;
  }
  ?>
</body>
</html>