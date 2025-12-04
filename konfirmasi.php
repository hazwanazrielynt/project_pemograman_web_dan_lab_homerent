<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: login_user.php");
    exit;
}

$id_admin = "1";


$id_pelanggan = $_SESSION['pelanggan_id'];
$nama     = $_SESSION['nama'];
$domisili = $_SESSION['domisili'];
$no_hp    = $_SESSION['no_hp'];


$id_rumah = $_POST['id_rumah'] ?? '';
$checkin  = $_POST['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? '';


if (!$id_rumah || !$checkin || !$checkout) {
    echo "Data tidak lengkap.";
    exit;
}


$rumah = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT * FROM rumah WHERE id_rumah='$id_rumah'"
));


$start  = strtotime($checkin);
$end    = strtotime($checkout);
$durasi = ($end - $start) / 86400;

$harga = $rumah['harga_sewa'];
$total_harga = $durasi * $harga;


if (isset($_POST['konfirmasi'])) {

    mysqli_query(
        $conn,
        "INSERT INTO sewa (id_pelanggan, id_admin, id_rumah, tanggal_sewa, tanggal_kembali, total_harga)
         VALUES ('$id_pelanggan', '$id_admin', '$id_rumah', '$checkin', '$checkout', '$total_harga')"
    );

    mysqli_query(
        $conn,
        "UPDATE rumah SET status='Sedang Disewa' WHERE id_rumah='$id_rumah'"
    );

    header("Location: dashboard.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Konfirmasi Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="main-content">
        <div class="content-box">
            <div class="container mt-4">

                <h3>Konfirmasi Pesanan</h3>
                <hr>

                <h4>Data Diri</h4>
                <ul>
                    <li>Nama: <?= $nama ?></li>
                    <li>Domisili: <?= $domisili ?></li>
                    <li>No HP: <?= $no_hp ?></li>
                </ul>

                <h4>Detail Rumah</h4>
                <ul>
                    <li>Foto Rumah: <?= $rumah['foto_rumah'] ?></li>
                    <li>Wilayah: <?= $rumah['wilayah'] ?></li>
                    <li>Alamat: <?= $rumah['alamat'] ?></li>
                    <li>Harga per Hari: Rp <?= number_format($harga, 0, ',', '.') ?></li>
                </ul>

                <h4>Detail Sewa</h4>
                <ul>
                    <li>Check-in: <?= $checkin ?></li>
                    <li>Check-out: <?= $checkout ?></li>
                    <li>Durasi: <?= $durasi ?> hari</li>
                    <li><b>Total Harga: Rp <?= number_format($total_harga, 0, ',', '.') ?></b></li>
                </ul>

                <form method="POST">
                    <input type="hidden" name="id_rumah" value="<?= $id_rumah ?>">
                    <input type="hidden" name="checkin" value="<?= $checkin ?>">
                    <input type="hidden" name="checkout" value="<?= $checkout ?>">
                    <input type="hidden" name="total_harga" value="<?= $total_harga ?>">

                    <button type="submit" name="konfirmasi" class="btn btn-success">
                        Konfirmasi Pesanan
                    </button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>