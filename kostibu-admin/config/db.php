<?php
$host = "localhost";
$user = "root"; // default XAMPP
$pass = ""; // kosongkan jika belum diubah
$db   = "kostibu"; // sesuaikan dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
