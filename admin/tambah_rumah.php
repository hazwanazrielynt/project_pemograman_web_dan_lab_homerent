<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Rumah</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="main-content">

    <div class="content-box">
      <h2>Tambah Data Rumah</h2>

      <form method="POST" class="form-add" enctype="multipart/form-data">

        <label>Foto Rumah:</label><br>
        <input type="file" name="foto_rumah" required><br><br>

        <label>Wilayah:</label><br>
         <select name="wilayah">
          <option value="Batam Center">Batam Center</option>
          <option value="Lubuk Baja">Lubuk Baja</option>
          <option value="Batu Aji">Batu Aji</option>
        </select> <br><br>
        <label>Alamat:</label><br>
        <input type="text" name="alamat" required><br><br>

        <label>Harga Sewa:</label><br>
        <input type="number" name="harga_sewa" required><br><br>

        <label>Status:</label><br>
        <select name="status">
          <option value="Tersedia">Tersedia</option>
          <option value="Sedang Disewa">Sedang Disewa</option>
        </select>
        <br><br>
<div class="form-buttons">
    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
</div>
      </form>
    </div>
  </div>
<?php
if(isset($_POST['simpan'])){
    $foto = $_FILES["foto_rumah"] ["name"];
    $tmp = $_FILES["foto_rumah"] ["tmp_name"];
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
    $query = "INSERT INTO rumah (foto_rumah, wilayah, alamat, harga_sewa, status)
         VALUES ('uploads/$namaBaru', '$wilayah', '$alamat', '$harga_sewa', '$status')";
  mysqli_query($conn, $query);
    header("Location: data_rumah_admin.php");
    exit;
}
?>
</body>
</html>
