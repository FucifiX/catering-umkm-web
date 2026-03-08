<?php
include 'koneksi.php';

$kode = mysqli_real_escape_string($conn, $_GET['kode_pesanan']);

$query = mysqli_query($conn, "
  SELECT o.*, m.nama AS menu_nama, m.gambar, m.harga AS menu_harga 
  FROM orders o
  JOIN menu m ON o.menu_id = m.id
  WHERE o.kode_pesanan = '$kode'
");

$order = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Pesanan</title>
    <link href="assets/img/daunicon.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling_dynamic/styles-struk.css">
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-card">
            <div class="receipt-header">
                <h1>Struk Pesanan</h1>
                <div class="receipt-code">#<?= $order['kode_pesanan'] ?></div>
            </div>
            
            <div class="receipt-section">
                <h2>Detail Pelanggan</h2>
                <div class="receipt-row">
                    <span class="label">Nama</span>
                    <span class="value"><?= htmlspecialchars($order['nama_lengkap']) ?></span>
                </div>
                <div class="receipt-row">
                    <span class="label">Alamat</span>
                    <span class="value"><?= htmlspecialchars($order['alamat']) ?></span>
                </div>
                <div class="receipt-row">
                    <span class="label">WhatsApp</span>
                    <span class="value"><?= htmlspecialchars($order['no_wa']) ?></span>
                </div>
                <div class="receipt-row">
                    <span class="label">Email</span>
                    <span class="value"><?= htmlspecialchars($order['email']) ?></span>
                </div>
            </div>
            
            <div class="receipt-section">
                <h2>Detail Pesanan</h2>
                <div class="menu-item">
                <img src="assets/img/menu/<?= $order['gambar'] ?>" alt="<?= htmlspecialchars($order['menu_nama']) ?>" class="menu-image">

                    <div class="menu-details">
                        <h3><?= htmlspecialchars($order['menu_nama']) ?></h3>
                        <div class="menu-price">Rp <?= number_format($order['menu_harga'], 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
            
            <div class="receipt-actions">
                <a href="https://wa.me/6285893588741?text=Halo,%20saya%20mau%20konfirmasi%20pesanan%20<?= $order['kode_pesanan'] ?>" 
                   class="whatsapp-button" target="_blank">
                    <span class="icon">📱</span> Konfirmasi via WhatsApp
                </a></br>
                <p>Konfirmasi Pesanan Anda Melalui WhatsApp</p>
                <a href="index.html" class="btn-kembali">← Kembali ke Beranda</a>

            </div>

            
            
            <div class="receipt-footer">
                <p>Terima kasih atas pesanan Anda</p>
            </div>
        </div>
    </div>
</body>
</html>