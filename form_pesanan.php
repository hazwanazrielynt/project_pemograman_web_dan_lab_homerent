<?php
include 'koneksi.php';

$id_rumah = $_GET['id'];
$rumah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rumah WHERE id_rumah='$id_rumah'"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkin & Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container mt-4">

        <div class="main-content">
            <div class="content-box">

                <h3 class="mb-3">Form Pemesanan Sewa Rumah (Bulanan)</h3>
                <div class="mb-3">
                    <img src="<?= $rumah['foto_rumah']; ?>" class="img-fluid rounded" style="height:250px; object-fit:cover;">
                </div>

                <p><b>Wilayah:</b> <?= $rumah['wilayah']; ?></p>
                <p><b>Alamat:</b> <?= $rumah['alamat']; ?></p>
                <p><b>Harga per Bulan:</b>
                    <span class="text-danger fw-bold">
                        Rp <?= number_format($rumah['harga_sewa'], 0, ',', '.'); ?>
                    </span>
                </p>

                <hr>
                <form method="POST" action="konfirmasi.php">
                    <input type="hidden" name="id_rumah" value="<?= $id_rumah ?>">

                    <div class="mb-3">
                        <label>Tanggal Check-in</label>
                        <input type="date" name="checkin" required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Check-out</label>
                        <input type="date" name="checkout" required class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Lanjutkan ke Konfirmasi
                    </button>
                </form>

            </div>
        </div>

    </div>
</body>

</html>