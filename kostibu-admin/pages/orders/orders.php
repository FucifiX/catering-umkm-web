<?php
include __DIR__ . '/../../config/db.php';

$basePath = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($basePath, '/');
?>

<h2>Data Pesanan</h2>

<!-- Input pencarian dengan ikon -->
<div class="search-wrapper" style="margin-bottom: 15px;">
    <i class="fas fa-search"></i>
    <input type="text" id="orderSearch" placeholder="Cari Nama, Kode Pesanan, Menu...">
</div>



<!-- Tabel Responsif -->
<div class="table-responsive">
    <table class="table-data">
        <thead>
            <tr>
                <th>NO</th>
                <th>Kode Pesanan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No WA</th>
                <th>Email</th>
                <th>Menu</th>
                <th>Harga</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT orders.*, menu.nama AS nama_menu, menu.harga 
                  FROM orders 
                  JOIN menu ON orders.menu_id = menu.id 
                  ORDER BY orders.created_at DESC";

        $result = $conn->query($query);
        $no = 1;

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id         = $row['id'];
                $kode       = htmlspecialchars($row['kode_pesanan']);
                $nama       = htmlspecialchars($row['nama_lengkap']);
                $alamat     = htmlspecialchars($row['alamat']);
                $wa         = htmlspecialchars($row['no_wa']);
                $email      = htmlspecialchars($row['email']);
                $menu       = htmlspecialchars($row['nama_menu']);
                $harga      = number_format($row['harga'], 0, ',', '.');
                $waktu      = htmlspecialchars($row['created_at']);

                echo "<tr>
                        <td>$no</td>
                        <td>$kode</td>
                        <td>$nama</td>
                        <td class='text-justify'>$alamat</td>
                        <td>$wa</td>
                        <td>$email</td>
                        <td>$menu</td>
                        <td class='price'>Rp $harga</td>
                        <td>$waktu</td>
                        <td>
                            <div class='action-buttons'>
                                <a href='?page=orders/orders_edit&id=$id' class='btn btn-edit'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <a href='?page=orders/orders_delete&id=$id' class='btn btn-delete' onclick=\"return confirm('Yakin ingin menghapus pesanan ini?')\">
                                    <i class='fas fa-trash'></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>";
                $no++;
            }
        } else {
            echo "<tr><td colspan='10' style='text-align:center; padding:15px;'>Tidak ada data pesanan.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- ✅ JS pencarian -->
<script src="<?= $basePath ?>/assets/js/orders-search.js"></script>
