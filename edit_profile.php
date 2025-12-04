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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama      = $_POST['nama'];
    $domisili  = $_POST['domisili'];
    $no_hp     = $_POST['no_hp'];
    $username  = $_POST['username'];
    $password  = $_POST['password'];

    $update = $conn->prepare("
        UPDATE pelanggan 
        SET nama=?, domisili=?, no_hp=?, username=?, password=? 
        WHERE id_pelanggan=?
    ");
    $update->bind_param("sssssi", $nama, $domisili, $no_hp, $username, $password, $id);

    if ($update->execute()) {
        echo "<script> window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Gagal update!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="profile-card">

        <div class="profile-header">
            <img src="https://i.pinimg.com/736x/5a/bd/98/5abd985735a8fd4adcb0e795de6a1005.jpg" alt="Foto Profil">
            <h2>Edit Profil</h2>
            <p>Perbarui informasi akun Anda</p>
        </div>

        <form method="POST" class="form-add">

            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= $data['nama']; ?>" required>

            <label>Domisili</label>
            <input type="text" name="domisili" value="<?= $data['domisili']; ?>" required>

            <label>No HP</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required>

            <label>Username</label>
            <input type="text" name="username" value="<?= $data['username']; ?>" required>

            <label>Password</label>
            <input type="text" name="password" value="<?= $data['password']; ?>" required>

            <button type="submit" name="update" class="btn-save">Simpan Perubahan</button>

            <a href="profile.php" class="back-link">Kembali ke Profil</a>
        </form>

    </div>
</body>

</html>