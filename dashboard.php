<?php
session_start();
if (!isset($_SESSION['pelanggan_id'])) {
  header("Location: login_user.php");
  exit;
}
include 'koneksi.php';

$query_batam_center = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batam Center'");
$data_batam_center = mysqli_fetch_assoc($query_batam_center);

$query_lubuk_baja = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Lubuk Baja'");
$data_lubuk_baja = mysqli_fetch_assoc($query_lubuk_baja);

$query_batu_aji = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rumah WHERE wilayah='Batu Aji'");
$data_batu_aji = mysqli_fetch_assoc($query_batu_aji);
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
          <a class="nav-link active" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="sewa_batamcenter.php">Sewa Rumah</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>
      </ul>
    </div>
    </div>
  </nav>
  <div class="layout">
    <main class="main-content">
      <div class="header">
        <h2><?php echo "Selamat Datang, " . ($_SESSION['nama'] ?? ''); ?></h2>
        <div class="datetime" id="datetime">
          <?php
          date_default_timezone_set('Asia/Jakarta');
          $datetime = new DateTime();
          $day = $datetime->format('l');
          $date = $datetime->format('d');
          $month = $datetime->format('F');
          $year = $datetime->format('Y');
          echo "$day, $date $month $year";
          ?>
        </div>
      </div>
      <section class="content-box">
        <h2>HomeRent Present</h2>
        <p>Kami hadir membantu proses penyewaan rumah biar nggak ribet. Sistemnya udah otomatis mulai dari data pelanggan, daftar rumah, transaksi sewa secara otomatis.</p>
        <button class="btn" onclick="window.location.href='sewa_batamcenter.php'">Ayo Mulai Sewa Rumah</button>
        <h3>Area Hunian yang Bisa Anda Sewa di HomeRent</h3>
        <div class="motor-grid">
          <div class="motor-card">
            <p>BATAM CENTER</p>
            <span><?= $data_batam_center['total']; ?></span>
          </div>
          <div class="motor-card">
            <p>LUBUK BAJA</p>
            <span><?= $data_lubuk_baja['total']; ?></span>
          </div>
          <div class="motor-card">
            <p>BATU AJI</p>
            <span><?= $data_batu_aji['total']; ?></span>
          </div>
        </div>
      </section>
    </main>
    <aside class="sidebar-right">
      <h3>Promo</h3>

      <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

          <div class="carousel-item active">
            <img src="uploads/download (2).jpg" class="d-block w-100 promo-img" alt="Promo 1">
          </div>

          <div class="carousel-item">
            <img src="uploads/download.jpg" class="d-block w-100 promo-img" alt="Promo 2">
          </div>

          <div class="carousel-item">
            <img src="uploads/lalapan.jpg" class="d-block w-100 promo-img" alt="Promo 3">
          </div>

        </div>
      </div>
    </aside>

  </div>
  <div class="layout-card">
    <main class="main-content-card">
      <section class="content-box-rumah">
        <h2>Rumah Yang Paling Sering Disewa</h2>

        <div class="container mt-1">
          <div class="row">

            <?php
            $result = mysqli_query($conn, "SELECT * FROM rumah limit 4");
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