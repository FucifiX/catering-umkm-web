<?php
// Jalankan session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect jika belum login
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit;
}

// Koneksi ke DB
require_once __DIR__ . '/../../config/db.php';

// Ambil ID user dari session
$userId = $_SESSION['admin']['id'];

$success = $error = '';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword     = $_POST['old_password'] ?? '';
    $newPassword     = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validasi input
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Semua field harus diisi!";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Ambil password lama dari DB
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        // Verifikasi password lama
        if (!password_verify($oldPassword, $user['password'])) {
            $error = "Password lama salah!";
        } else {
            // Hash password baru dan update
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $hashed, $userId);

            if ($update->execute()) {
                $success = "Password berhasil diubah.";
            } else {
                $error = "Gagal menyimpan password.";
            }

            $update->close();
        }
    }
}
?>

<!-- ✅ Tampilan form langsung di sini -->
<h2>Ubah Password</h2>

<?php if ($success): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php elseif ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" class="form-grid" style="max-width: 400px;">
    <div class="form-row">
        <label>Password Lama</label>
        <input type="password" name="old_password" required>
    </div>
    <div class="form-row">
        <label>Password Baru</label>
        <input type="password" name="new_password" required>
    </div>
    <div class="form-row">
        <label>Konfirmasi Password</label>
        <input type="password" name="confirm_password" required>
    </div>
    <div class="form-row">
        <button type="submit" class="btn-submit">Simpan Password</button>
    </div>
</form>
