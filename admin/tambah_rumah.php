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

      <form method="POST" class="form-add">

        <label>Nama Rumah:</label><br>
        <input type="text" name="nama_rumah" required><br><br>

        <label>Wilayah:</label><br>
         <select name="wilayah">
          <option value="Batam Center">Batam Center</option>
          <option value="Baloi">Baloi</option>
          <option value="Lubuk Baja">Lubuk Baja</option>
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
    $nama_rumah = $_POST['nama_rumah'];
    $wilayah = $_POST['wilayah'];
    $alamat = $_POST['alamat'];
    $harga_sewa = $_POST['harga_sewa'];
    $status = $_POST['status'];

    // Perbaikan urutan kolom - sesuaikan dengan struktur tabel kamu
    $query = "INSERT INTO rumah (nama_rumah, wilayah, alamat, harga_sewa, status)
              VALUES ('$nama_rumah', '$wilayah', '$alamat', '$harga_sewa', '$status')";

    mysqli_query($conn, $query);
    header("Location: data_rumah_admin.php");
    exit;
}
?>

</body>
</html>
