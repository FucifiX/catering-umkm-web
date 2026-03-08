<h2>Tambah User</h2>

<form method="POST" enctype="multipart/form-data" class="form-grid">
    <div class="form-row">
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-row">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-row">
        <label>Email</label>
        <input type="email" name="email">
    </div>
    <div class="form-row">
        <label>Nama Lengkap</label>
        <input type="text" name="nama_lengkap" required>
    </div>
    <div class="form-row">
        <label>Foto Avatar</label>
        <input type="file" name="avatar" accept="image/*">
    </div>
    <div class="form-row">
        <button type="submit" class="btn btn-submit">Simpan</button>
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../../config/db.php';

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = trim($_POST['email']);
    $nama = trim($_POST['nama_lengkap']);

    // Validasi: username tidak boleh sama
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>Username sudah digunakan.</p>";
        exit;
    }
    $check->close();

    // Simpan ke tabel users
    $stmt1 = $conn->prepare("INSERT INTO users (username, password, email, nama_lengkap) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $username, $password, $email, $nama);
    if ($stmt1->execute()) {
        $userId = $stmt1->insert_id;

        // Proses avatar (jika ada)
        $avatarName = null;
        if (!empty($_FILES['avatar']['name'])) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $avatarName = 'avatar_' . time() . '_' . rand(100,999) . '.' . $ext;
            $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/user/" . $avatarName;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath);
        }

        // Simpan ke tabel admin
        $stmt2 = $conn->prepare("INSERT INTO admin (id, name, email, avatar) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $userId, $nama, $email, $avatarName);
        $stmt2->execute();

        echo "<script>alert('User berhasil ditambahkan'); location.href='?page=users/users';</script>";
    } else {
        echo "<p style='color:red;'>Gagal menyimpan data: {$conn->error}</p>";
    }

    $stmt1->close();
}
?>
