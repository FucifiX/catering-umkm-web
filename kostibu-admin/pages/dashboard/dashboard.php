<div class="dashboard">
    <h2>Selamat Datang di <span style="color: var(--topbar-color);">Dashboard Admin KostIBU</span></h2>

    <div class="info-boxes">
        <!-- BOX MENU -->
        <div class="info-box">
            <i class="fas fa-utensils"></i>
            <div class="info-content">
                <h3>Menu</h3>
                <p>
                    <?php
                    $menuCount = $conn->query("SELECT COUNT(*) as total FROM menu")->fetch_assoc()['total'];
                    echo "$menuCount item";
                    ?>
                </p>
            </div>
        </div>

        <!-- BOX PESANAN -->
        <div class="info-box">
            <i class="fas fa-shopping-cart"></i>
            <div class="info-content">
                <h3>Pesanan</h3>
                <p>
                    <?php
                    $orderCount = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
                    echo "$orderCount pesanan";
                    ?>
                </p>
            </div>
        </div>

        <!-- BOX PENGGUNA -->
        <div class="info-box">
            <i class="fas fa-users"></i>
            <div class="info-content">
                <h3>Pengguna</h3>
                <p>
                    <?php
                    $userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
                    echo "$userCount user";
                    ?>
                </p>
            </div>
        </div>

        <!-- BOX MESSAGE -->
        <div class="info-box">
            <i class="fas fa-comment-dots"></i> <!-- ganti dari 'fa-message' ke 'fa-comment-dots' -->
            <div class="info-content">
                <h3>Comment</h3>
                <p>
                    <?php
                    $messageCount = $conn->query("SELECT COUNT(*) as total FROM contact_messages")->fetch_assoc()['total'];
                    echo "$messageCount message";
                    ?>
                </p>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; background: rgba(255,255,255,0.85); padding: 15px; border-radius: 10px;">
        <p style="margin: 0; color: #444;">
            Gunakan panel di sebelah kiri untuk mengelola data menu, pesanan, pengguna, dan pengaturan lainnya.
        </p>
    </div>
</div>
