<?php
include __DIR__ . '/../../config/db.php';

$id = (int) $_GET['id'];
$dataUser = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
$dataAdmin = $conn->query("SELECT * FROM admin WHERE id = $id")->fetch_assoc();

// Jika tidak ditemukan
if (!$dataUser) {
    echo "<p style='color:red;'>User tidak ditemukan.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nama = $_POST['nama_lengkap'];

    // Upload avatar jika ada
    $avatarFile = $_FILES['avatar'];
    $avatarName = $dataAdmin['avatar'] ?? null;

    if ($avatarFile['name']) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/user/";
        $ext = pathinfo($avatarFile['name'], PATHINFO_EXTENSION);
        $newAvatarName = 'avatar_' . time() . '_' . rand(100,999) . '.' . $ext;
        $uploadPath = $uploadDir . $newAvatarName;

        if (move_uploaded_file($avatarFile['tmp_name'], $uploadPath)) {
            $avatarName = $newAvatarName;
        } else {
            echo "<p style='color:red;'>Upload avatar gagal!</p>";
            exit;
        }
    }

    // Update data di tabel users
    $stmt1 = $conn->prepare("UPDATE users SET email=?, nama_lengkap=? WHERE id=?");
    $stmt1->bind_param("ssi", $email, $nama, $id);
    $stmt1->execute();

    // Update data di tabel admin
    if ($conn->query("SELECT id FROM admin WHERE id = $id")->num_rows > 0) {
        $stmt2 = $conn->prepare("UPDATE admin SET email=?, name=?, avatar=? WHERE id=?");
        $stmt2->bind_param("sssi", $email, $nama, $avatarName, $id);
        $stmt2->execute();
    } else {
        // Insert jika belum ada
        $stmt2 = $conn->prepare("INSERT INTO admin (id, email, name, avatar) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $id, $email, $nama, $avatarName);
        $stmt2->execute();
    }

    echo "<script>alert('User berhasil diperbarui'); location.href='?page=users/users';</script>";
    exit;
}
?>

<h2>Edit User</h2>
<form method="POST" enctype="multipart/form-data" class="form-grid">
    <div class="form-row">
        <label>Username</label>
        <input type="text" value="<?= htmlspecialchars($dataUser['username']) ?>" disabled>
    </div>
    <div class="form-row">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($dataUser['email']) ?>" required>
    </div>
    <div class="form-row">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($dataUser['nama_lengkap']) ?>" required>
    </div>
    <div class="form-row">
        <label>Foto Avatar</label>
        <input type="file" name="avatar" accept="image/*">
        <?php if (!empty($dataAdmin['avatar'])): ?>
            <br><img src="/KostIBU/assets/img/user/<?= htmlspecialchars($dataAdmin['avatar']) ?>" alt="Avatar" style="width:60px;border-radius:50%;">
        <?php endif; ?>
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-submit">Simpan Perubahan</button>
    </div>
</form>
