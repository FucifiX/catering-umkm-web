<?php
include __DIR__ . '/../../config/db.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM menu WHERE id=$id")->fetch_assoc();
?>

<h2>Edit Menu</h2>

<form method="POST" enctype="multipart/form-data" class="form-grid">

    <div class="form-row">
        <label for="nama">Nama Menu</label>
        <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
    </div>

    <div class="form-row">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
    </div>

    <div class="form-row">
        <label for="bahan">Bahan</label>
        <textarea name="bahan" id="bahan" required><?= htmlspecialchars($data['bahan']) ?></textarea>
    </div>

    <div class="form-row">
        <label for="harga">Harga (Rp)</label>
        <input type="number" name="harga" id="harga" value="<?= $data['harga'] ?>" required>
    </div>

    <div class="form-row">
        <label>Gambar Saat Ini</label>
        <img src="/KostIBU/assets/img/menu/<?= htmlspecialchars($data['gambar']) ?>" width="100" style="border-radius:6px;">
    </div>

    <div class="form-row">
        <label for="gambar">Upload Gambar Baru</label>
        <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png">
    </div>

    <div class="form-row">
        <label></label>
        <button type="submit" name="update" class="btn-submit">Update</button>
    </div>
</form>

<?php
if (isset($_POST['update'])) {
    $nama       = htmlspecialchars($_POST['nama']);
    $deskripsi  = htmlspecialchars($_POST['deskripsi']);
    $bahan      = htmlspecialchars($_POST['bahan']);
    $harga      = floatval($_POST['harga']);

    $gambarBaru = $data['gambar']; // default gunakan gambar lama

    if (!empty($_FILES['gambar']['name'])) {
        $fileName = $_FILES['gambar']['name'];
        $tmpName  = $_FILES['gambar']['tmp_name'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed)) {
            echo "<p style='color:red;'>Ekstensi gambar tidak diperbolehkan. Hanya JPG dan PNG.</p>";
            exit;
        }

        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $nama)));
        $gambarBaru = time() . '-' . $slug . '.' . $ext;

        $uploadDir = realpath(__DIR__ . '/../../../') . '/assets/img/menu/';
        $uploadPath = $uploadDir . $gambarBaru;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($tmpName, $uploadPath)) {
            echo "<p style='color:red;'>Gagal upload gambar ke $uploadPath</p>";
            exit;
        }
    }

    $sql = "UPDATE menu SET 
            nama='$nama', 
            deskripsi='$deskripsi', 
            bahan='$bahan', 
            harga='$harga', 
            gambar='$gambarBaru' 
            WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Berhasil diupdate! <a href='?page=menu/menu'>Kembali</a></p>";
    } else {
        echo "<p style='color:red;'>Gagal update: " . $conn->error . "</p>";
    }
}
?>
