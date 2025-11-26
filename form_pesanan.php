<?php
include 'koneksi.php';

$id_rumah = $_GET['id'];
$rumah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rumah WHERE id_rumah='$id_rumah'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Diri</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
<div class="container mt-4">
    <div class="main-content">
    <div class="content-box">
    <h3>Form Pemesanan Sewa Rumah</h3>
    <form method="POST" action="konfirmasi.php">
    <input type="hidden" name="id_rumah" value="<?= $id_rumah ?>">

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Domisili</label>
        <input type="text" name="domisili" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Check-in</label>
        <input type="date" name="checkin" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Tanggal Check-out</label>
        <input type="date" name="checkout" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Lanjutkan</button>
    </div>
    </div>
</form>
</div>
</body>
</html>
