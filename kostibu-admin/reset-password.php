<?php
include 'config/db.php';

$token = $_GET['token'] ?? '';
$error = $success = "";

// Cek token valid
if ($token) {
    $stmt = $conn->prepare("SELECT id, token_expiry FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['id'];
        $expired = strtotime($user['token_expiry']);

        if ($expired < time()) {
            $error = "Link reset password sudah kadaluarsa.";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new = $_POST['new_password'];
            $confirm = $_POST['confirm_password'];

            if ($new !== $confirm) {
                $error = "Konfirmasi password tidak cocok.";
            } else {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
                $update->bind_param("si", $hash, $userId);
                if ($update->execute()) {
                    $success = "Password berhasil direset. Silakan login kembali.";
                } else {
                    $error = "Gagal menyimpan password baru.";
                }
                $update->close();
            }
        }
    } else {
        $error = "Token tidak valid atau tidak ditemukan.";
    }

    $stmt->close();
} else {
    $error = "Token tidak tersedia.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
<div class="auth-container">
    <h2>Reset Password</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php else: ?>
        <form method="POST">
            <input type="password" name="new_password" placeholder="Password Baru" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit">Simpan Password</button>
        </form>
    <?php endif; ?>

    <div class="auth-footer">
        <a href="login.php">Kembali ke Login</a>
    </div>
</div>
</body>
</html>
