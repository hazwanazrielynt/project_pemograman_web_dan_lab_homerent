<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data POST
$id_rumah   = $_POST['id_rumah'] ?? '';
$checkin    = $_POST['checkin'] ?? '';
$lama_sewa  = isset($_POST['lama_sewa']) ? (int)$_POST['lama_sewa'] : 1;

$id_pelanggan = $_SESSION['pelanggan_id'];
$nama         = $_SESSION['nama'];
$domisili     = $_SESSION['domisili'];
$no_hp        = $_SESSION['no_hp'];
$id_admin     = 1; // admin default

// Ambil data rumah
$rumah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rumah WHERE id_rumah='$id_rumah'"));

// Hitung checkout otomatis
$checkin_date = new DateTime($checkin);
$checkout_date = clone $checkin_date;
$checkout_date->modify("+$lama_sewa month");
$checkout = $checkout_date->format('Y-m-d');

// Hitung total harga
$total_harga = $rumah['harga_sewa'] * $lama_sewa;

// Jika form konfirmasi dikirim
if (isset($_POST['konfirmasi'])) {
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? 'Tunai';

    mysqli_query($conn, "INSERT INTO sewa 
    (id_pelanggan, id_admin, id_rumah, tanggal_sewa, tanggal_kembali, lama_sewa, total_harga, metode_pembayaran, status_pembayaran)
    VALUES 
    ('$id_pelanggan', '$id_admin', '$id_rumah', '$checkin', '$checkout', '$lama_sewa', '$total_harga', '$metode_pembayaran', 'BELUM LUNAS')");

    $last_id = mysqli_insert_id($conn);

    mysqli_query($conn, "UPDATE rumah SET status='Sedang Disewa' WHERE id_rumah='$id_rumah'");

    if ($metode_pembayaran == 'QRIS') {
        header("Location: qris.php?id_sewa=$last_id");
    } else {
        header("Location: dashboard.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Konfirmasi Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

  <div class="main-content">
    <div class="content-box" style="max-width: 520px;">

      <h2 class="text-center mb-4">Konfirmasi Pesanan</h2>
      <h4 class="mb-2">Data Diri</h4>
      <ul style="line-height: 1.8;">
        <li><b>Nama:</b> <?= $nama ?></li>
        <li><b>Domisili:</b> <?= $domisili ?></li>
        <li><b>No HP:</b> <?= $no_hp ?></li>
      </ul>
      <hr>
      <h4 class="mb-2">Detail Rumah</h4>
      <ul style="line-height: 1.8;">
        <li><b>Wilayah:</b> <?= $rumah['wilayah'] ?></li>
        <li><b>Alamat:</b> <?= $rumah['alamat'] ?></li>
        <li><b>Harga / Bulan:</b> 
          <span class="text-primary fw-bold">
            Rp <?= number_format($rumah['harga_sewa'],0,',','.') ?>
          </span>
        </li>
      </ul>
      <hr>
      <h4 class="mb-2">Detail Sewa</h4>
      <ul style="line-height: 1.8;">
        <li><b>Check-in:</b> <?= $checkin ?></li>
        <li><b>Check-out:</b> <?= $checkout ?></li>
        <li>
          <b>Total Harga:</b>
          <span class="text-success fw-bold fs-5">
            Rp <?= number_format($total_harga, 0, ',', '.') ?>
          </span>
        </li> 
      </ul>

      <hr>
      <form method="POST" class="form-add">
        <input type="hidden" name="id_rumah" value="<?= $id_rumah ?>">
        <input type="hidden" name="checkin" value="<?= $checkin ?>">
        <input type="hidden" name="checkout" value="<?= $checkout ?>">
        <input type="hidden" name="lama_sewa" value="<?= $lama_sewa ?>">
        <label><b>Metode Pembayaran</b></label>
        <select name="metode_pembayaran" class="form-control mb-4" required>
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="Tunai">Tunai</option>
            <option value="QRIS">QRIS</option>
        </select>

        <button type="submit" name="konfirmasi" class="btn w-100">
          Konfirmasi Pesanan
        </button>

        <button type="button" onclick="window.history.back();" class="btn btn-danger w-100 mt-2">
          Kembali
        </button>
      </form>

    </div>
  </div>

</body>

</html>
