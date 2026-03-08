<h2>Tambah Menu Baru</h2>

<form method="POST" enctype="multipart/form-data" class="form-grid">

    <div class="form-row">
        <label for="nama">Nama Menu</label>
        <input type="text" name="nama" id="nama" placeholder="Contoh: Nasi Goreng Spesial" required>
    </div>

    <div class="form-row">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi menu..." required></textarea>
    </div>

    <div class="form-row">
        <label for="bahan">Bahan</label>
        <textarea name="bahan" id="bahan" placeholder="Bahan-bahan menu..." required></textarea>
    </div>

    <div class="form-row">
        <label for="harga">Harga (Rp)</label>
        <input type="number" name="harga" id="harga" placeholder="10000" required>
    </div>

    <div class="form-row">
        <label for="gambar">Upload Gambar</label>
        <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/png" required>
    </div>

    <div class="form-row">
        <label style="visibility:hidden;">Preview</label>
        <img id="preview" src="#" alt="Preview" style="display:none;" class="preview-img">
    </div>

    <div class="form-row">
        <label style="visibility:hidden;">Simpan</label>
        <button type="submit" name="simpan" class="btn-submit">Simpan</button>
    </div>
</form>


<!-- Preview.js -->
<script src="../../assets/js/preview.js"></script>

<?php
if (isset($_POST['simpan'])) {
    include __DIR__ . '/../../config/db.php';

    $nama       = htmlspecialchars($_POST['nama']);
    $deskripsi  = htmlspecialchars($_POST['deskripsi']);
    $bahan      = htmlspecialchars($_POST['bahan']);
    $harga      = floatval($_POST['harga']);

    if ($harga <= 0) {
        echo "<p style='color:red;'>Harga tidak boleh 0 atau negatif.</p>";
        return;
    }

    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        echo "<p style='color:red;'>Upload gambar gagal: {$_FILES['gambar']['error']}</p>";
        return;
    }

    $originalName = $_FILES['gambar']['name'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png'];

    if (!in_array($ext, $allowedExt)) {
        echo "<p style='color:red;'>Ekstensi tidak diperbolehkan. Hanya JPG dan PNG.</p>";
        return;
    }

    if ($_FILES['gambar']['size'] > 2 * 4000 * 4000) {
        echo "<p style='color:red;'>Ukuran gambar maksimal 2MB.</p>";
        return;
    }

    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $nama)));
    $namaFileBaru = time() . '-' . $slug . '.' . $ext;

    $tmp = $_FILES['gambar']['tmp_name'];
    $targetDir = realpath(__DIR__ . '/../../../') . '/assets/img/menu/';
    $targetPath = $targetDir . $namaFileBaru;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($tmp, $targetPath)) {
        $sql = "INSERT INTO menu (nama, deskripsi, bahan, harga, gambar)
                VALUES ('$nama', '$deskripsi', '$bahan', '$harga', '$namaFileBaru')";

        if ($conn->query($sql)) {
            echo "<p style='color:green;'>Menu berhasil ditambahkan!</p>";
            echo "<p><a href='?page=menu/menu'>Kembali ke Menu</a></p>";
            echo "<p>Lihat gambar: <a href='/KostIBU/assets/img/menu/$namaFileBaru' target='_blank'>$namaFileBaru</a></p>";
        } else {
            echo "<p style='color:red;'>Database error: {$conn->error}</p>";
        }
    } else {
        echo "<p style='color:red;'>Gagal menyimpan file ke $targetPath</p>";
    }
}
?>
