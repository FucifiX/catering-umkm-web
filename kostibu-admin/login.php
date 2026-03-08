<?php
session_start();
include 'config/db.php';

$error = "";

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Ambil username dari cookie jika remember me aktif
$rememberedUser = $_COOKIE['remember_user'] ?? '';

// Proses form login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi
    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi!";
    } else {
        // Cari user
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Simpan ke session
                $_SESSION['admin'] = $user;

                // Remember me: simpan username ke cookie selama 7 hari
                if (isset($_POST['remember'])) {
                    setcookie('remember_user', $username, time() + (86400 * 7), "/");
                } else {
                    setcookie('remember_user', '', time() - 3600, "/");
                }

                header("Location: index.php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - KostIBU</title>
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="auth-container">
    <h2>Login Admin</h2>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required
               value="<?= htmlspecialchars($rememberedUser) ?>" autocomplete="username" autofocus>

        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">

        <div class="auth-options">
            <label>
                <input type="checkbox" name="remember" <?= isset($_COOKIE['remember_user']) ? 'checked' : '' ?>>
                Remember me
            </label>
            <a href="forgot-password.php">Lupa password?</a>
        </div>

        <button type="submit" name="login">Login</button>

        <div class="auth-footer">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>
    </form>
</div>
</body>
</html>
