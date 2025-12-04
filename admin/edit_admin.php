<?php
include 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Admin</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="main-content">
    <div class="content-box">
      <h2>Edit Data Admin</h2>
      <form method="POST" class="form-add">
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= $data['username']; ?>" required><br><br>

        <label>Password:</label><br>
        <input type="text" name="password" value="<?= $data['password']; ?>" required><br><br>

        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required><br><br>

        <div class="form-buttons">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <button type="button" onclick="window.history.back();" class="btn btn-danger">Kembali</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $query = "UPDATE admin SET
              username = '$username',
              password = '$password',
              nama = '$nama'
              WHERE id_admin = $id";
    mysqli_query($conn, $query);
    header("Location: data_admin.php");
    exit;
  }
  ?>
</body>

</html>