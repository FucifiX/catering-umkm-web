<?php
session_start();
include 'config/db.php';

$errors = [];
$username = $email = $nama = "";

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $nama     = trim($_POST['nama_lengkap']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validasi input
    if ($username === '' || $password === '' || $nama === '') {
        $errors[] = "Username, Nama Lengkap, dan Password wajib diisi.";
    } elseif ($password !== $confirm) {
        $errors[] = "Konfirmasi password tidak cocok.";
    } else {
        // Cek username apakah sudah ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = "Username sudah digunakan.";
        }
        $stmt->close();
    }

    // Jika tidak ada error → simpan ke database
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, nama_lengkap) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hash, $email, $nama);

        if ($stmt->execute()) {
            echo "<script>alert('Akun berhasil dibuat. Silakan login!'); window.location='login.php';</script>";
            exit;
        } else {
            $errors[] = "Gagal menyimpan ke database: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - KostIBU</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="login-box">
    <h2>Daftar Akun</h2>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <p class="error"><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>" required>
        <input type="email" name="email" placeholder="Email (Opsional)" value="<?= htmlspecialchars($email) ?>">
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" value="<?= htmlspecialchars($nama) ?>" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
        <button type="submit">Daftar</button>
    </form>

    <div style="text-align:center; margin-top:10px;">
        <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
    </div>
</div>
</body>
</html>
