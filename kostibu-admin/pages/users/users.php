<h2>Data Pengguna</h2>

<!-- Tombol Tambah (opsional) -->
<a href="?page=users/users_add" class="btn btn-submit" style="margin-bottom: 15px;">
    <i class="fas fa-plus"></i> Tambah User
</a>

<!-- Tabel Data Users -->
<div class="table-responsive">
    <table class="table-data">
        <thead>
            <tr>
                <th>NO</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
<?php
include __DIR__ . '/../../config/db.php';

$query = "SELECT 
            users.id, users.username, users.email, users.nama_lengkap, 
            admin.avatar 
          FROM users 
          LEFT JOIN admin ON users.id = admin.id 
          ORDER BY users.id ASC";

$result = $conn->query($query);
$no = 1;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $avatar = !empty($row['avatar']) ? $row['avatar'] : 'default.png';
        $avatarPath = "/KostIBU/assets/img/user/" . htmlspecialchars($avatar);
        $username = htmlspecialchars($row['username']);
        $nama     = htmlspecialchars($row['nama_lengkap']);
        $email    = htmlspecialchars($row['email']);

        echo "<tr>
                <td>$no</td>
                <td><img src='$avatarPath' alt='Avatar' style='width:40px; height:40px; border-radius:50%;'></td>
                <td>$username</td>
                <td>$nama</td>
                <td>$email</td>
                <td>
                    <div class='action-buttons'>
                        <a href='?page=users/users_edit&id={$row['id']}' class='btn btn-edit'>
                            <i class='fas fa-edit'></i> Edit
                        </a>
                        <a href='?page=users/users_delete&id={$row['id']}' class='btn btn-delete' onclick=\"return confirm('Hapus user ini?')\">
                            <i class='fas fa-trash'></i> Hapus
                        </a>
                    </div>
                </td>
              </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data pengguna.</td></tr>";
}
?>
        </tbody>
    </table>
</div>
