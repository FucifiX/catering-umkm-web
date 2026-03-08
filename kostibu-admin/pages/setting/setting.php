<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/../../config/db.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: ../../login.php");
    exit;
}

$user = $_SESSION['admin'];
$userId = (int)$user['id'];

// Ambil data user & avatar
$query = "SELECT users.*, admin.avatar 
          FROM users 
          LEFT JOIN admin ON users.id = admin.id 
          WHERE users.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<p style='color:red;'>User tidak ditemukan</p>";
    exit;
}
$data = $result->fetch_assoc();
$stmt->close();

$avatar = $data['avatar'] ?? 'default.png';

// Ambil setting warna tema
$setting = $conn->query("SELECT * FROM tb_settings WHERE id = 1")->fetch_assoc();

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $topbar  = htmlspecialchars($_POST['topbar_color']);
    $sidebar = htmlspecialchars($_POST['sidebar_color']);

    // Upload avatar
    $newAvatar = $avatar;
    if (!empty($_FILES['avatar']['name'])) {
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $newName = 'user_' . time() . '.' . $ext;
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/user/" . $newName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
            $oldPath = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/user/" . $avatar;
            if (file_exists($oldPath) && $avatar !== 'default.png') unlink($oldPath);
            $newAvatar = $newName;
        }
    }

    // Update tabel users
    $stmt = $conn->prepare("UPDATE users SET email = ?, nama_lengkap = ? WHERE id = ?");
    $stmt->bind_param("ssi", $email, $name, $userId);
    $stmt->execute();
    $stmt->close();

    // Update/Insert ke admin
    $cek = $conn->prepare("SELECT id FROM admin WHERE id = ?");
    $cek->bind_param("i", $userId);
    $cek->execute();
    $cekResult = $cek->get_result();
    $cek->close();

    if ($cekResult->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE admin SET name = ?, email = ?, avatar = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $newAvatar, $userId);
    } else {
        $stmt = $conn->prepare("INSERT INTO admin (id, name, email, avatar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $name, $email, $newAvatar);
    }
    $stmt->execute();
    $stmt->close();

    // Update warna tema
    $stmt = $conn->prepare("UPDATE tb_settings SET topbar_color = ?, sidebar_color = ? WHERE id = 1");
    $stmt->bind_param("ss", $topbar, $sidebar);
    $stmt->execute();
    $stmt->close();

    // Update session
    $_SESSION['admin']['email'] = $email;
    $_SESSION['admin']['nama_lengkap'] = $name;

    echo "<script>alert('Pengaturan berhasil disimpan'); location.href='?page=setting/setting';</script>";
    exit;
}
?>

<!-- Tampilan Form -->
<h2>Pengaturan Akun</h2>

<form method="POST" enctype="multipart/form-data" class="form-grid" style="max-width: 500px;">
    <div class="form-row">
        <label>Username</label>
        <input type="text" value="<?= htmlspecialchars($data['username']) ?>" readonly>
    </div>

    <div class="form-row">
        <label>Peran</label>
        <input type="text" value="<?= htmlspecialchars($data['role'] ?? 'user') ?>" readonly>
    </div>

    <div class="form-row">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
    </div>

    <div class="form-row">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
    </div>

    <div class="form-row">
        <label>Foto Profil</label>
        <input type="file" name="avatar" accept="image/*">
        <?php if ($avatar): ?>
            <img src="/KostIBU/assets/img/user/<?= htmlspecialchars($avatar) ?>" width="80" style="margin-top:10px; border-radius: 50%;">
        <?php endif; ?>
    </div>

    <hr>

    <div class="form-row">
        <label>Warna Topbar</label>
        <input type="color" name="topbar_color" value="<?= htmlspecialchars($setting['topbar_color']) ?>">
    </div>

    <div class="form-row">
        <label>Warna Sidebar</label>
        <input type="color" name="sidebar_color" value="<?= htmlspecialchars($setting['sidebar_color']) ?>">
    </div>

    <div class="form-row">
        <button type="submit" class="btn-submit">Simpan Pengaturan</button>
    </div>
</form>

<script src="<?= $basePath ?>/assets/js/setting-validate.js"></script>
