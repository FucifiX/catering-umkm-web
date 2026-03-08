<?php
include 'config/db.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);

    // Validasi input tidak kosong
    if (empty($username) || empty($email)) {
        $error = "Username dan email wajib diisi.";
    } else {
        // Cek apakah user ada
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $newPass = password_hash("12345678", PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update->bind_param("ss", $newPass, $username);
            if ($update->execute()) {
                $success = "Password berhasil direset ke <b>12345678</b>. Silakan login kembali.";
            } else {
                $error = "Terjadi kesalahan saat memperbarui password.";
            }
            $update->close();
        } else {
            $error = "Data tidak cocok. Username atau email salah.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - KostIBU</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="login-box">
    <h2>Lupa Password</h2>

    <?php if (!empty($success)): ?>
        <p class="success" style="color: green; text-align: center;">
            <?= $success ?>
        </p>
    <?php elseif (!empty($error)): ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email terdaftar" required>
        <button type="submit">Reset Password</button>
    </form>

    <div style="text-align:center; margin-top:10px;">
        <small><a href="login.php">Kembali ke Login</a></small>
    </div>
</div>
</body>
</html>
