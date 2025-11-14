<?php
$host = "localhost";      // Server MySQL (default: localhost)
$user = "root";           // Username default Laragon
$pass = "";               // Password default kosong di Laragon
$db   = "motorent";    // Ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Mengecek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
} else {
  // echo "Koneksi berhasil!"; // boleh dihapus kalau udah jalan
}
?>
