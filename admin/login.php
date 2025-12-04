<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {

            $_SESSION['admin_id'] = $user['id_admin'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin_nama'] = $user['admin_nama'];

            header("Location: dashboard_admin.php");
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username admin tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="stylelogin.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="container">
        <div class="form-box login">
            <form action="" method="POST">
                <h1>Login Admin</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="forgot.html">Forgot Password?</a>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div>

    </div>
    </div>
</body>

</html>