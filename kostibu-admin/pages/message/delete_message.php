<?php
include __DIR__ . '/../../config/db.php';

// Ambil ID pesan dari parameter URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi ID
if ($id <= 0) {
    echo "<script>
        alert('ID tidak valid.');
        location.href='?page=message/messages';
    </script>";
    exit;
}

// Hapus data pesan
$stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();

if ($success) {
    echo "<script>
        alert('Pesan berhasil dihapus.');
        location.href='?page=message/messages';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus pesan.');
        location.href='?page=message/messages';
    </script>";
}
?>
