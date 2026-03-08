<?php
include 'koneksi.php';
$menu_query = mysqli_query($conn, "SELECT * FROM menu");
$menu_items = [];
while ($row = mysqli_fetch_assoc($menu_query)) {
    $menu_items[] = $row;
}
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>Form Pemesanan KostIBU</title>
  <link href="assets/img/daunicon.png" rel="icon">
  <link href="styling_dynamic/order_page.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Form Pemesanan</h2>
        
        <div class="overthink-decoration">
            <span class="overthink-text">OVERTHINK THE DETAILS</span>
        </div>
        
        <form action="proses_order.php" method="post">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" required>
            
            <label>Alamat:</label>
            <textarea name="alamat" required></textarea>
            
            <label>No WhatsApp:</label>
            <input type="text" name="no_wa" id="no_wa" pattern="[0-9]+" inputmode="numeric" placeholder="08xxxxxxxxxx">
            
            <label>Email Aktif:</label>
            <input type="email" name="email" required>
            
            <label>Pilih Menu:</label>
            <div class="menu-options">
            <?php foreach ($menu_items as $menu): ?>
                <label class="menu-card">
                <input type="radio" name="menu_id" value="<?= $menu['id'] ?>" required
                    data-harga="<?= $menu['harga'] ?>"
                    data-gambar="<?= $menu['gambar'] ?>"
                    data-nama="<?= htmlspecialchars($menu['nama']) ?>"
                >
                <img src="assets/img/menu/<?= $menu['gambar'] ?>" alt="<?= htmlspecialchars($menu['nama']) ?>">
                <h4><?= htmlspecialchars($menu['nama']) ?></h4>
                <p>Rp <?= number_format($menu['harga'], 0, ',', '.') ?></p>
                </label>
            <?php endforeach; ?>
            </div>
            
            <div id="menu-info" style="display: none;">
                <p id="menu-nama"></p>
                <img id="menu-preview" src="" alt="">
                <p id="menu-harga"></p>
            </div>
            
            <label>Kode Pesanan:</label>
            <div class="kode-container">
                <input type="text" name="kode_pesanan" id="kode_pesanan" readonly required>
                <button type="button" onclick="generateKode()">Generate</button>
            </div>
            
            <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            
            <button type="submit">Pesan Sekarang</button>
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
    const menuSelect = document.getElementById('menu-select');
    const menuInfo = document.getElementById('menu-info');
    
    menuSelect.addEventListener('change', function() {
        if (this.value === "") {
            menuInfo.style.display = 'none';
            return;
        }
        
        menuInfo.style.display = 'block';
        const selected = this.options[this.selectedIndex];
        document.getElementById('menu-nama').innerText = selected.dataset.nama;
        document.getElementById('menu-harga').innerText = "Rp " + Number(selected.dataset.harga).toLocaleString('id-ID');
        
        const img = document.getElementById('menu-preview');
        if (selected.dataset.gambar) {
            img.src = 'uploads/menu/' + selected.dataset.gambar;
            img.style.display = 'block';
        } else {
            img.style.display = 'none';
        }
    });
    
    function generateKode() {
        const rand = Math.random().toString(36).substr(2, 5).toUpperCase();
        const kode = 'ORDER-' + Date.now().toString().slice(-4) + '-' + rand;
        document.getElementById('kode_pesanan').value = kode;
    }
    document.getElementById('no_wa').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    </script>
</body>
</html>