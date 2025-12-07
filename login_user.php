<?php
session_start();
include 'koneksi.php';


if (isset($_SESSION['pelanggan_id'])) {
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("SELECT * FROM pelanggan WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();


        if ($password === $user['password']) {

            $_SESSION['pelanggan_id'] = $user['id_pelanggan'];
            $_SESSION['nama']         = $user['nama'];
            $_SESSION['domisili']     = $user['domisili'];
            $_SESSION['no_hp']        = $user['no_hp'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }
}

if (isset($_POST['register'])) {

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $domisili = $_POST['domisili'];
    $no_hp    = $_POST['no_hp'];
    $password = $_POST['password'];

    $cek = $conn->prepare("SELECT * FROM pelanggan WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $hasil = $cek->get_result();

    if ($hasil->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO pelanggan (nama, username, domisili, no_hp, password)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $nama, $username, $domisili, $no_hp, $password);
        $stmt->execute();

        $id_baru = $conn->insert_id;

        $_SESSION['pelanggan_id'] = $id_baru;
        $_SESSION['nama']         = $nama;
        $_SESSION['domisili']     = $domisili;
        $_SESSION['no_hp']        = $no_hp;

        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup homerent</title>
    <link rel="stylesheet" href="stylelogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
  <body>

      <div class="container">
          <div class="form-box login">
              <form action="" method="POST">
                  <h1>Login</h1>
                 <?php if(isset($error) && isset($_POST['login'])): ?>
                    <div class="alert-error">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                  <div class="input-box">
                      <input type="text" name="username" placeholder="Username" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="password" name="password" placeholder="Password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>    
                  <button type="submit" name="login" class="btn">Login</button>
              </form>
          </div>
            <div class="form-box register">
                <form action="" method="POST">
                    <h1>Registration</h1>

                    <input type="hidden" name="register">

                    <div class="input-box">
                        <input type="text" name="nama" placeholder="Nama Lengkap" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class='bx bxs-user'></i>
                    </div>

                    <div class="input-box">
                        <input type="text" name="domisili" placeholder="Domisili" required>
                        <i class='bx bxs-home' ></i>
                    </div>

                    <div class="input-box">
                        <input type="text" name="no_hp" placeholder="No HP" required>
                        <i class='bx bxs-phone'></i>
                    </div>

                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class='bx bxs-lock-alt' ></i>
                    </div>

                    <button type="submit" name="register" class="btn">Register</button>
                </form>
            </div>

          <div class="toggle-box">
              <div class="toggle-panel toggle-left">
                  <h1>Hello, Welcome!</h1>
                  <p>Don't have an account?</p>
                  <button class="btn register-btn">Register</button>
              </div>

              <div class="toggle-panel toggle-right">
                  <h1>Welcome Back!</h1>
                  <p>Already have an account?</p>
                  <button class="btn login-btn">Login</button>
              </div>
          </div>
      </div>

      <script src="login.js"></script>
  </body>
</html>
