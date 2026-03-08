<?php
include __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data pin
$query = "SELECT * FROM map_pins WHERE id=$id LIMIT 1";
$result = $conn->query($query);
$pin = $result->fetch_assoc();

if (!$pin) {
    echo "<p>Data Berhasil Diperbarui.</p>";
    exit;
}

// Pecah string images
$images = !empty($pin['images']) ? explode(',', $pin['images']) : [];
?>

<h2>Edit Pin Map</h2>

<form action="?page=gallery/galeri_update" method="POST" enctype="multipart/form-data" class="form-pin-edit">
    <input type="hidden" name="id" value="<?= $id ?>">

    <div class="form-group">
        <label>Judul:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($pin['title']) ?>" required>
    </div>

    <div class="form-group">
        <label>Deskripsi:</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($pin['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label>Posisi X:</label>
        <input type="number" name="pos_x" value="<?= (int)$pin['pos_x'] ?>" min="0" max="3000"
               oninput="this.nextElementSibling.value = this.value">
        <input type="range" min="0" max="3000" value="<?= (int)$pin['pos_x'] ?>"
               oninput="this.previousElementSibling.value = this.value">
    </div>

    <div class="form-group">
        <label>Posisi Y:</label>
        <input type="number" name="pos_y" value="<?= (int)$pin['pos_y'] ?>" min="0" max="2000"
               oninput="this.nextElementSibling.value = this.value">
        <input type="range" min="0" max="2000" value="<?= (int)$pin['pos_y'] ?>"
               oninput="this.previousElementSibling.value = this.value">
    </div>

    <div class="form-group">
        <label>Tambah Gambar Baru:</label>
        <input type="file" name="new_images[]" multiple accept="image/*">
    </div>

    <div class="form-group">
        <label>Daftar Gambar:</label>
        <div class="pin-image-list">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $img): ?>
                    <?php $img = trim($img); ?>
                    <div class="pin-image-item">
                        <img src="/KostIBU/assets/img/gallery/<?= htmlspecialchars($img) ?>" alt="Gambar Pin">
                        <a href="?page=gallery/galeri_delete_image&id=<?= $id ?>&image=<?= urlencode($img) ?>"
                           class="delete-img-btn"
                           onclick="return confirm('Hapus gambar ini?')">✖</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="font-size: 14px; color: #777;">Belum ada gambar.</p>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" class="btn btn-submit">Simpan Perubahan</button>
</form>


