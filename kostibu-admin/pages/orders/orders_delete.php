<?php
include __DIR__ . '/../../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color:red;'>ID tidak valid.</p>";
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM orders WHERE id=$id");

echo "<script>location.href='?page=orders/orders';</script>";
