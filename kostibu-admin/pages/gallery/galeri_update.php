<?php
include __DIR__ . '/../../config/db.php';

// Validasi ID
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id < 1) {
    die('ID tidak valid!');
}

// Ambil POST data
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$pos_x = (int)$_POST['pos_x'];
$pos_y = (int)$_POST['pos_y'];

// Ambil gambar lama
$query = "SELECT images FROM map_pins WHERE id = $id LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$images = [];
if ($row && !empty($row['images'])) {
    $images = explode(',', $row['images']);
}

// Upload gambar baru kalau ada
if (!empty($_FILES['new_images']['name'][0])) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/gallery/";
    foreach ($_FILES['new_images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['new_images']['name'][$key]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $images[] = $fileName;
        }
    }
}

// Gabung gambar jadi string
$imagesStr = implode(',', $images);

// Update DB
$updateQuery = "UPDATE map_pins SET
    title='$title',
    description='$description',
    pos_x=$pos_x,
    pos_y=$pos_y,
    images='$imagesStr'
    WHERE id=$id";

if ($conn->query($updateQuery)) {
    header('Location: ?page=gallery/galeri_edit');
    exit();
} else {
    echo "Gagal update: " . $conn->error;
}
?>
