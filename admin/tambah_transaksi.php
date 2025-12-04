<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Transaksi</title>

  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
  <div class="main-content">

    <div class="content-box">
      <h2>Tambah Data Transaksi</h2>

      <form method="POST" class="form-add">

        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Nomor Telepon:</label><br>
        <input type="text" name="no_hp" required><br><br>

        <label>Domisili:</label><br>
        <input type="text" name="domisili" required><br><br>

        <label>Rumah yang Disewa:</label><br>
        <select name="id_rumah" required>
          <option value="">-- Pilih Rumah --</option>

          <?php
          $rumah = mysqli_query($conn, "SELECT * FROM rumah");
          while ($r = mysqli_fetch_assoc($rumah)) {
            echo "<option value='{$r['id_rumah']}'>
                        {$r['nama_rumah']} - {$r['alamat']} (Rp " . number_format($r['harga_sewa']) . ")
                      </option>";
          }
          ?>
        </select><br><br>

        <label>Tanggal Sewa:</label><br>
        <input type="date" name="tanggal_sewa" required><br><br>

        <label>Tanggal Kembali:</label><br>
        <input type="date" name="tanggal_kembali" required><br><br>

        <div class="form-buttons">
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-danger">Kembali</button>
        </div>

      </form>
    </div>
  </div>
  <?php
  if (isset($_POST['simpan'])) {

    $nama            = $_POST['nama'];
    $no_hp           = $_POST['no_hp'];
    $domisili        = $_POST['domisili'];
    $id_rumah        = $_POST['id_rumah'];
    $tanggal_sewa    = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    session_start();
    $id_admin = $_SESSION['admin_id'];
    $nama_admin = $_SESSION['admin_nama'];

    $getRumah = mysqli_query($conn, "SELECT harga_sewa FROM rumah WHERE id_rumah='$id_rumah'");
    $dataRumah = mysqli_fetch_assoc($getRumah);
    $harga_per_malam = $dataRumah['harga_sewa'];

    $malam = (strtotime($tanggal_kembali) - strtotime($tanggal_sewa)) / 86400;
    if ($malam < 1) $malam = 1;

    $total_harga = $malam * $harga_per_malam;

    mysqli_query($conn, "INSERT INTO pelanggan (nama, domisili, no_hp) VALUES ('$nama', '$domisili', '$no_hp')");
    $id_pelanggan = mysqli_insert_id($conn);

    $insert = mysqli_query(
      $conn,
      "INSERT INTO sewa (id_pelanggan, id_admin, id_rumah, tanggal_sewa, tanggal_kembali, total_harga, nama_admin)
         VALUES ('$id_pelanggan','$id_admin','$id_rumah','$tanggal_sewa','$tanggal_kembali','$total_harga', '$nama_admin')"
    );

    if ($insert) {
      header("Location: data_transaksi_admin.php");
      exit;
    } else {
      echo 'Error: ' . mysqli_error($conn);
    }
  }
  ?>

</body>

</html>