<?php
include 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM rumah WHERE id_rumah = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Rumah</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Edit Data Rumah</h2>

      <form method="POST" class="form-add">
        <label>Wilayah:</label><br>
        <select name="wilayah">
          <option value="Batam Center" <?= $data['wilayah'] == "Batam Center" ? "selected" : "" ?>>Batam Center</option>
          <option value="Lubuk Baja" <?= $data['wilayah'] == "Lubuk Baja" ? "selected" : "" ?>>Lubuk Baja</option>
          <option value="Batu Aji" <?= $data['wilayah'] == "Batu Aji" ? "selected" : "" ?>>Batu Aji</option>
        </select>
        <br><br>

        <label>Alamat:</label><br>
        <input type="text" name="alamat" value="<?= $data['alamat']; ?>" required><br><br>

        <label>Harga Sewa:</label><br>
        <input type="number" name="harga_sewa" value="<?= $data['harga_sewa']; ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status">
          <option value="Tersedia" <?= $data['status'] == "Tersedia" ? "selected" : "" ?>>Tersedia</option>
          <option value="Sedang Disewa" <?= $data['status'] == "Sedang Disewa" ? "selected" : "" ?>>Sedang Disewa</option>
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
if(isset($_POST['update'])){
    $wilayah = $_POST['wilayah'];
    $alamat = $_POST['alamat'];
    $harga_sewa = $_POST['harga_sewa'];
    $status = $_POST['status'];
    $folder = "../uploads/";
    if (!is_dir($folder)) {
     mkdir($folder, 0777, true);
  }
    $namaBaru = time() . "_" . $foto;
    move_uploaded_file($tmp, $folder . $namaBaru);
    $query = "UPDATE rumah SET
              wilayah = '$wilayah',
              alamat = '$alamat',
              harga_sewa = '$harga_sewa',
              status = '$status'
              WHERE id_rumah = $id";
    mysqli_query($conn, $query);
    header("Location: data_rumah_admin.php");
    exit;
}
?>
</body>
</html>
