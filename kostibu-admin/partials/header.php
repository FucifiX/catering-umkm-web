<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Path relatif ke root
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($basePath, '/');

// Koneksi database
require_once __DIR__ . '/../config/db.php';

// Cek login
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data user dari session
$user = $_SESSION['admin'];
$adminId = $user['id'];

// Ambil data dari tabel admin (jika ada avatar)
$admin = $conn->query("SELECT * FROM admin WHERE id = $adminId")->fetch_assoc();

// Avatar fallback
$avatarName = !empty($admin['avatar']) ? $admin['avatar'] : 'default.png';
$avatarPathLocal = $_SERVER['DOCUMENT_ROOT'] . "/KostIBU/assets/img/user/$avatarName";
if (!file_exists($avatarPathLocal)) {
    $avatarName = 'default.png';
}
$avatarUrl = "/KostIBU/assets/img/user/" . htmlspecialchars($avatarName);

// Ambil setting warna
$setting = $conn->query("SELECT * FROM tb_settings WHERE id = 1")->fetch_assoc();
$topbarColor = $setting['topbar_color'] ?? '#8cf740';
$sidebarColor = $setting['sidebar_color'] ?? '#66af32';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - KostIBU</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/KostIBU/favicon.ico">
    <link rel="shortcut icon" href="/KostIBU/favicon.ico">
    <link rel="shortcut icon" href="/KostIBU/favicon.ico" type="image/x-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- CSS Lokal -->
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/buttons.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/tables.css">
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/galeri.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Dinamis Warna -->
    <style>
        :root {
            --topbar-color: <?= htmlspecialchars($topbarColor) ?>;
            --sidebar-color: <?= htmlspecialchars($sidebarColor) ?>;
        }
    </style>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-right">
        <!-- Tombol setting -->
        <a href="?page=setting" class="settings-icon" title="Pengaturan">
            <i class="fas fa-cog"></i>
        </a>

        <!-- Dropdown profil -->
        <div class="profile-wrapper">
            <img src="<?= $avatarUrl ?>" class="profile-avatar" id="profileToggle" alt="Avatar">
            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-header">
                    <img src="<?= $avatarUrl ?>" alt="User">
                    <b><?= htmlspecialchars($admin['name'] ?? $user['username']) ?></b>
                    <small><?= htmlspecialchars($admin['email'] ?? '-') ?></small>
                </div>
                <div class="profile-actions">
                    <a href="?page=change-password/update_password">Change Password</a>
                    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Toggle Profil -->
<script src="<?= $basePath ?>/assets/js/profile-toggle.js"></script>
