<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $no_wa = mysqli_real_escape_string($conn, $_POST['no_wa']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $menu_id = (int)$_POST['menu_id'];
    $kode_pesanan = mysqli_real_escape_string($conn, $_POST['kode_pesanan']);

    // Verifikasi CAPTCHA Google
    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);
    if(intval($responseKeys["success"]) !== 1) {
        die("Verifikasi CAPTCHA gagal.");
    }

    // Cek harga menu
    $menu_result = mysqli_query($conn, "SELECT harga FROM menu WHERE id=$menu_id");
    $menu = mysqli_fetch_assoc($menu_result);
    $harga = $menu['harga'];

    // Simpan ke DB
    $query = "INSERT INTO orders (kode_pesanan, nama_lengkap, alamat, no_wa, email, menu_id, harga)
              VALUES ('$kode_pesanan', '$nama', '$alamat', '$no_wa', '$email', '$menu_id', '$harga')";
    if (mysqli_query($conn, $query)) {
        header("Location: struk.php?kode_pesanan=$kode_pesanan");
        exit;
    } else {
        echo "Gagal menyimpan pesanan: " . mysqli_error($conn);
    }
}
?>
