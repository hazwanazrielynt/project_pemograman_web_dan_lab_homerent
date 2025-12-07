<?php
include 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pelanggan</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Edit Data Pelanggan</h2>
      <form method="POST" class="form-add">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required><br><br>
        <label>Domisili:</label><br>
        <input type="text" name="domisili" value="<?= $data['domisili']; ?>" required><br><br>
        <label>Nomor Telepon:</label><br>
        <input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required><br><br>
        <div class="form-buttons">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $domisili = $_POST['domisili'];
    $no_hp = $_POST['no_hp'];

    $query = "UPDATE pelanggan SET
              nama= '$nama',
              domisili = '$domisili',
              no_hp = '$no_hp'
              WHERE id_pelanggan = $id";
    mysqli_query($conn, $query);
    header("Location: data_pelanggan.php");
    exit;
  }
  ?>
</body>
</html>