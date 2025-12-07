<?php
include 'koneksi.php';
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
          <a class="nav-link active" href="sewa_batamcenter.php">Sewa Rumah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="history.php">History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
      </ul>
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
        <li><a href="sewa_batamcenter.php">Batam Center</a></li>
        <li><a href="sewa_lubukbaja.php">Lubuk Baja</a></li>
        <li class="active"><a href="sewa_batuaji.php">Batu Aji</a></li>
      </ul>
    </aside>

    <div class="container mt-1">
      <div class="row">

        <?php
        $result = mysqli_query($conn, "SELECT * FROM rumah WHERE wilayah='Batu Aji'");
        while ($row = mysqli_fetch_assoc($result)) {

          $foto_rumah = $row['foto_rumah'];
          $wilayah    = $row['wilayah'];
          $alamat     = $row['alamat'];
          $fasilitas  = $row['fasilitas'];
          $harga_sewa = $row['harga_sewa'];
          $status     = $row['status'];

          $Class = ($status === 'Tersedia' || strtolower($status) === 'available') ? 'success' : 'secondary';

          $button = ($status === 'Tersedia' || strtolower($status) === 'available')
            ? '
          <button 
            class="btn btn-primary mt-3"
            data-bs-toggle="modal"
            data-bs-target="#modalDetail"
            data-id="' . $row['id_rumah'] . '"
            data-foto="' . $foto_rumah . '"
            data-wilayah="' . $wilayah . '"
            data-alamat="' . $alamat . '"
            data-fasilitas="' . $fasilitas . '"
            data-harga="' . $harga_sewa . '"
            data-status="' . $status . '"
          >
            Pesan
          </button>
          '
            : '<button class="btn btn-secondary mt-3" disabled>Sudah Disewa</button>';

          echo '
        <div class="col-6 col-md-4 col-lg-3 mb-4">
          <div class="card h-100">
            <img src="' . $foto_rumah . '" class="card-img-top" style="height:200px; object-fit:cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">' . $wilayah . '</h5>
              <p class="card-text small flex-grow-1">' . $alamat . '</p>

              <div class="d-flex justify-content-between align-items-center mt-2">
                <strong>Rp ' . number_format($harga_sewa, 0, ',', '.') . '</strong>
                <span class="badge bg-' . $Class . '">' . $status . '</span>
              </div>

              ' . $button . '
            </div>
          </div>
        </div>';
        }
        ?>

      </div>
    </div>
  </div>

  <div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h2 class="modal-title">Detail Rumah</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <img id="modalFoto" class="img-fluid rounded mb-3" style="height:300px; width:100%; object-fit:cover;">

          <ul class="list-group">
            <li class="list-group-item"><b>Wilayah:</b> <span id="modalWilayah"></span></li>
            <li class="list-group-item"><b>Alamat:</b> <span id="modalAlamat"></span></li>
            <li class="list-group-item"><b>Fasilitas:</b> <span id="modalFasilitas"></span></li>
            <li class="list-group-item"><b>Harga:</b> Rp <span id="modalHarga"></span></li>
            <li class="list-group-item"><b>Status:</b> <span id="modalStatus"></span></li>
          </ul>
        </div>

        <div class="modal-footer">
          <form method="GET" action="form_pesanan.php" class="w-100">
            <input type="hidden" name="id" id="modalIdRumah">
            <button type="submit" class="btn btn-success w-100">Pesan Sekarang</button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    var modal = document.getElementById('modalDetail')

    modal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget

      document.getElementById('modalFoto').src = button.getAttribute('data-foto')
      document.getElementById('modalWilayah').innerText = button.getAttribute('data-wilayah')
      document.getElementById('modalAlamat').innerText = button.getAttribute('data-alamat')
      document.getElementById('modalFasilitas').innerText = button.getAttribute('data-fasilitas')
      document.getElementById('modalHarga').innerText = new Intl.NumberFormat('id-ID').format(button.getAttribute('data-harga'))
      document.getElementById('modalStatus').innerText = button.getAttribute('data-status')
      document.getElementById('modalIdRumah').value = button.getAttribute('data-id')
    })
  </script>

</body>

</html>