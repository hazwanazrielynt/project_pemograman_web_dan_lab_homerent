<?php
session_start();

if (!isset($_SESSION['pelanggan_id'])) {
  header("Location: login.php");
  exit;
}

include 'koneksi.php';

$id = $_SESSION['pelanggan_id'];
$query = $conn->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
$query->bind_param("i", $id);
$query->execute();
$data = $query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomeRent Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sewa_batamcenter.php">Sewa Rumah</a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="history.php">History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="profile.php">Profile</a>
        </li>
      </ul>
    </div>
    </div>
  </nav>

  <div class="profile-card">
    <div class="profile-header">
      <img src=https://i.pinimg.com/736x/5a/bd/98/5abd985735a8fd4adcb0e795de6a1005.jpg>
      <h2><?php echo $data['nama']; ?></h2>
      <p><?php echo $data['username']; ?></p>
    </div>

    <br>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" value="<?php echo $data['nama']; ?>" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label>Domisili</label>
        <input type="text" class="form-control" value="<?php echo $data['domisili']; ?>" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label>No HP</label>
        <input type="text" class="form-control" value="<?php echo $data['no_hp']; ?>" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label>Username</label>
        <input type="text" class="form-control" value="<?php echo $data['username']; ?>" readonly>
      </div>
    </div>

    <a href="edit_profile.php" class="btn btn-save">Ubah Profil</a>
    <a href="logout.php" class="btn btn-logout">Logout</a>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>