<?php
include 'koneksi.php';

$id_rumah = $_GET['id'] ?? '';
$rumah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rumah WHERE id_rumah='$id_rumah'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Sewa Rumah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="main-content">
    <div class="content-box" style="max-width:520px;">
        <h2 class="text-center mb-4">Pemesanan Sewa Rumah</h2>
        <div class="mb-3 text-center">
            <img src="<?= $rumah['foto_rumah']; ?>" class="img-fluid rounded-4 shadow-sm" style="height:260px; width:100%; object-fit:cover;">
        </div>      
        <div class="mb-3">
            <p><b>Wilayah:</b> <?= $rumah['wilayah']; ?></p>
            <p><b>Alamat:</b> <?= $rumah['alamat']; ?></p>
            <p><b>Harga / Bulan:</b> Rp <?= number_format($rumah['harga_sewa'],0,',','.'); ?></p>
        </div>
        <hr>
        <form method="POST" action="konfirmasi.php" class="form-add">
            <input type="hidden" name="id_rumah" value="<?= $id_rumah ?>">
            <label>Tanggal Check-in</label>
            <input type="date" name="checkin" class="form-control mb-3" required>
            <label>Lama Sewa (bulan)</label>
            <select name="lama_sewa" class="form-control mb-4" required>
                <option value="1">1 Bulan</option>
                <option value="2">2 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="4">4 Bulan</option>
            </select>
            <button type="submit" class="btn w-100">Lanjutkan ke Konfirmasi</button>
            <button type="button" onclick="window.history.back();" class="btn btn-danger w-100 mt-2">Kembali</button>
        </form>
    </div>
</div>
</body>
</html>
