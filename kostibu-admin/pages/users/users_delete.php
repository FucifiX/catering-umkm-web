<?php
include __DIR__ . '/../../config/db.php';

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");

echo "<script>alert('User berhasil dihapus'); location.href='?page=users/users';</script>";
?>
