<?php
include __DIR__ . '/../../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color:red;'>ID tidak valid.</p>";
    exit;
}

$id = $_GET['id'];

// Ambil data pesanan
$data = $conn->query("SELECT * FROM orders WHERE id=$id")->fetch_assoc();
if (!$data) {
    echo "<p style='color:red;'>Data tidak ditemukan.</p>";
    exit;
}

// Ambil daftar menu
$menus = $conn->query("SELECT id, nama FROM menu");
?>

<h2>Edit Pesanan</h2>

<form method="POST" class="form-grid">

    <div class="form-row">
        <label for="kode_pesanan">Kode Pesanan</label>
        <input type="text" name="kode_pesanan" id="kode_pesanan" value="<?= htmlspecialchars($data['kode_pesanan']) ?>" required>
    </div>

    <div class="form-row">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" required>
    </div>

    <div class="form-row">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($data['alamat']) ?>" required>
    </div>

    <div class="form-row">
        <label for="no_wa">No WA</label>
        <input type="text" name="no_wa" id="no_wa" value="<?= htmlspecialchars($data['no_wa']) ?>" required>
    </div>

    <div class="form-row">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($data['email']) ?>" required>
    </div>

    <div class="form-row">
        <label for="menu_id">Pilih Menu</label>
        <select name="menu_id" id="menu_id" required>
            <option value="">-- Pilih Menu --</option>
            <?php while ($menu = $menus->fetch_assoc()) : ?>
                <option value="<?= $menu['id'] ?>" <?= $menu['id'] == $data['menu_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($menu['nama']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-row">
        <label></label>
        <button type="submit" name="update" class="btn-submit">Update</button>
    </div>
</form>

<?php
if (isset($_POST['update'])) {
    $kode_pesanan = htmlspecialchars($_POST['kode_pesanan']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $alamat       = htmlspecialchars($_POST['alamat']);
    $no_wa        = htmlspecialchars($_POST['no_wa']);
    $email        = htmlspecialchars($_POST['email']);
    $menu_id      = intval($_POST['menu_id']);

    $sql = "UPDATE orders SET 
                kode_pesanan='$kode_pesanan',
                nama_lengkap='$nama_lengkap',
                alamat='$alamat',
                no_wa='$no_wa',
                email='$email',
                menu_id=$menu_id
                WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Pesanan berhasil diperbarui. <a href='?page=orders/orders'>Kembali</a></p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>
