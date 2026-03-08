<?php
include __DIR__ . '/../../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$image = isset($_GET['image']) ? $_GET['image'] : '';

$query = "SELECT images FROM map_pins WHERE id=$id LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($row && $image) {
    $images = explode(',', $row['images']);

    // Ganti arrow function ke anonymous function
    $images = array_filter($images, function($img) use ($image) {
        return trim($img) !== $image;
    });

    $imagesStr = implode(',', $images);

    // Hapus file fisik
    $filePath = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/gallery/$image";
    if (file_exists($filePath)) unlink($filePath);

    // Update DB
    $conn->query("UPDATE map_pins SET images='$imagesStr' WHERE id=$id");
}

header("Location: ?page=gallery/galeri_edit&id=$id");
exit();
?>
