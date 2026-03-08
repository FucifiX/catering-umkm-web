<?php
include __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Cek apakah menu sedang digunakan di tabel orders
$cek = $conn->prepare("SELECT COUNT(*) as total FROM orders WHERE menu_id = ?");
$cek->bind_param("i", $id);
$cek->execute();
$cekResult = $cek->get_result()->fetch_assoc();

if ($cekResult['total'] > 0) {
    echo "<script>
        alert('Menu tidak bisa dihapus karena masih digunakan di pesanan!');
        location.href='?page=menu/menu';
    </script>";
    exit;
}

// Ambil data menu untuk hapus gambar
$stmt = $conn->prepare("SELECT gambar FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$gambar = $result['gambar'] ?? null;

// Hapus gambar jika ada
$gambarPath = __DIR__ . '/../../assets/img/menu/' . $gambar;
if (!empty($gambar) && file_exists($gambarPath)) {
    unlink($gambarPath);
}

// Hapus data menu
$delete = $conn->prepare("DELETE FROM menu WHERE id = ?");
$delete->bind_param("i", $id);
$success = $delete->execute();

if ($success) {
    echo "<script>
        alert('Menu berhasil dihapus.');
        location.href='?page=menu/menu';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus menu.');
        location.href='?page=menu/menu';
    </script>";
}
?>
