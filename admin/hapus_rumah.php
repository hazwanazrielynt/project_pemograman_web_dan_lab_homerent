<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM rumah WHERE id_rumah=$id");

header("Location: data_rumah_admin.php");
?>
