<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menu Paket Tersedia</title>
  <link href="assets/img/daunicon.png" rel="icon">
  <link href="styling_dynamic/menu_page.css" rel="stylesheet">
</head>
<body>

<!-- Judul -->
<h1>Menu Paket Tersedia</h1>

vz<!-- Tombol Kembali -->
<a href="index.html" class="btn-kembali">← Kembali ke Beranda</a>

<!-- Daftar Menu -->
<div class="menu-container">
  <?php
  $query = "SELECT * FROM menu";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="menu-item"
              data-nama="' . htmlspecialchars($row['nama']) . '"
              data-deskripsi="' . htmlspecialchars($row['deskripsi']) . '"
              data-bahan="' . htmlspecialchars($row['bahan']) . '"
              data-gambar="assets/img/menu/' . urlencode($row['gambar']) . '">';
    echo '<img src="assets/img/menu/' . urlencode($row['gambar']) . '" alt="' . htmlspecialchars($row['nama']) . '">';
    echo '<h3>' . htmlspecialchars($row['nama']) . '</h3>';
    echo '<div class="harga">Rp ' . number_format($row['harga'], 0, ',', '.') . '</div>';
    echo '</div>';
  }
  ?>
</div>

<!-- Popup Modal -->
<div id="menuModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <div class="modal-body">
      <div class="modal-image">
        <img id="modalGambar" src="" alt="" />
      </div>
      <div class="modal-info">
        <h2 id="modalNama"></h2>
        <p id="modalDeskripsi"></p>
        <h4>Bahan:</h4>
        <p id="modalBahan"></p>
        <button class="order-btn" onclick="location.href='order_page.php'">
          Pesan Sekarang
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Script Modal -->
<script>
  const modal = document.getElementById("menuModal");
  const modalNama = document.getElementById("modalNama");
  const modalDeskripsi = document.getElementById("modalDeskripsi");
  const modalBahan = document.getElementById("modalBahan");
  const modalGambar = document.getElementById("modalGambar");
  const closeBtn = document.querySelector(".close-btn");

  document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", () => {
      modal.style.display = "block";
      modalNama.textContent = item.dataset.nama;
      modalDeskripsi.textContent = item.dataset.deskripsi;
      modalBahan.textContent = item.dataset.bahan;
      modalGambar.src = item.dataset.gambar;
      modalGambar.alt = item.dataset.nama;
    });
  });

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target == modal) {
      modal.style.display = "none";
    }
  });
</script>

    <div id="preloader">
        <div class="loader-ios">
            <div></div><div></div><div></div><div></div><div></div><div></div>
            <div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>


</body>
</html>
