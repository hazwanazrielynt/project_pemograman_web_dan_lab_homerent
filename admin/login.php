<?php
session_start();
include 'koneksi.php'; // file koneksi database

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query user berdasarkan username atau email
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        // Verifikasi password
        if(($password == $user['password'])){
            $_SESSION['admin_id'] = $user['id_admin'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin_id'] = $user['id_admin'];
            $_SESSION['nama'] = $user['nama'];
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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
    
</body>
</html>
