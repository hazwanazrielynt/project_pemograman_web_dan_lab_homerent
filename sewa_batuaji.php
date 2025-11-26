<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
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
          <a class="nav-link active" href="sewa_batamcenter.php">Sewa Rumah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">History</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<li class="nav-item dropdown d-lg-none">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
    Area Sewa
  </a>
  <ul class="dropdown-menu text-center">
    <li><a class="dropdown-item" href="sewa_batamcenter.php">Batam Center</a></li>
    <li><a class="dropdown-item" href="sewa_lubukbaja.php">Lubuk Baja</a></li>
    <li><a class="dropdown-item" href="sewa_batuaji.php">Batu Aji</a></li>
  </ul>
</li>
    <div class="layout-sewa">
    <aside class="sidebar-left">
      <ul>
        <li><a href="sewa_batamcenter.php">Batam Center </a></li>
        <li><a href="sewa_lubukbaja.php">Lubuk Baja</a></li>
        <li class="active">Batu Aji</li>
      </ul>
    </aside>
   <div class="container mt-1">
        <div class="row">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM rumah where wilayah='Batu Aji'");
            while ($row = mysqli_fetch_assoc($result)) {
                $foto_rumah=($row['foto_rumah']);
                $wilayah =($row['wilayah']);
                $alamat=($row['alamat']);
                $harga_sewa=number_format($row['harga_sewa'], 0, ',', '.');
                $status=($row['status']);
                $Class=($status === 'Tersedia' || strtolower($status) === 'available') ? 'success' : 'secondary';

                echo
                '<div class="col-6 col-md-4 col-lg-3 mb-4">
                  <div class="card h-100">
                   <img src="' . $foto_rumah . '" class="card-img-top" alt="' . $foto_rumah . '" style="height:200px;object-fit:cover;">
                   <div class="card-body d-flex flex-column">
                     <h5 class="card-title">' . $wilayah . '</h5>
                     <p class="card-text small flex-grow-1">' . $alamat . '</p>
                     <div class="d-flex justify-content-between align-items-center mt-2">
                        <strong>Rp ' . $harga_sewa . '</strong>
                        <span class="badge bg-' . $Class . '">' . $status . '</span>
                      </div>
                     <a href="form_pesanan.php?id=' . $row['id_rumah'] . '" class="btn btn-primary mt-3">Pesan</a>
                     </div>
                   </div>
                  </div>';
            }
            ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>