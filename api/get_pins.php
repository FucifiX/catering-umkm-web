<?php
header('Content-Type: application/json');
include '../koneksi.php'; // ✅ use your existing connection

$sql = "SELECT * FROM map_pins"; // your table name
$result = mysqli_query($conn, $sql);

$pins = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Convert images from comma-separated to array
    $images = explode(',', $row['images']);
    $images = array_map('trim', $images); // clean whitespace

    // Prepend the folder path
    foreach ($images as &$img) {
        $img = '../assets/img/gallery/' . $img;
    }

    $pins[] = [
        'title' => $row['title'],
        'description' => $row['description'],
        'pos_x' => (int)$row['pos_x'],
        'pos_y' => (int)$row['pos_y'],
        'images' => $images
    ];
}

echo json_encode($pins);
?>
