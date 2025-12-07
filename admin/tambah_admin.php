<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Admin</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Tambah Data Admin</h2>
      <form method="POST" class="form-add">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>
        <div class="form-buttons">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];

    $query = "INSERT INTO admin (username, password, nama)
              VALUES ('$username', '$password', '$nama')";
    mysqli_query($conn, $query);
    header("Location: data_admin.php");
    exit;
  }
  ?>
</body>
</html>