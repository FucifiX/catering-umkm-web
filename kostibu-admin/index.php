<?php
// Autentikasi dan koneksi database
include 'auth/check.php';
include 'config/db.php';
include 'partials/header.php';
include 'partials/sidebar.php';

// Default: ke dashboard/dashboard.php jika ?page tidak di-set
$page = $_GET['page'] ?? 'dashboard/dashboard';

// Cegah akses file sembarangan
$page = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $page);

// Cari file yang cocok
$paths = [
    "pages/$page.php",               // Misal: pages/dashboard/dashboard.php
    "pages/$page/index.php",        // Misal: pages/dashboard/dashboard/index.php
];

// Tambahan fallback pages/dashboard/dashboard.php
$parts = explode('/', $page);
$last = end($parts);
$paths[] = "pages/$page/$last.php";

// Cek file mana yang tersedia
$found = false;
foreach ($paths as $file) {
    if (file_exists($file)) {
        include $file;
        $found = true;
        break;
    }
}

// Tampilkan pesan jika file tidak ditemukan
if (!$found) {
    echo "<div style='padding: 20px; font-family: Poppins; color: red;'>
            <strong>Halaman tidak ditemukan:</strong> <code>pages/$page</code>
          </div>";
}

// Footer
include 'partials/footer.php';
?>
