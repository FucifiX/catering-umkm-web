<h2>Data Menu</h2>

<!-- Tombol Tambah Menu -->
<a href="?page=menu/menu_add" class="btn btn-submit" style="margin-bottom: 15px;">
    <i class="fas fa-plus"></i> Tambah Menu
</a>

<!-- Tabel Data Menu -->
<div class="table-responsive">
    <table class="table-data">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Bahan</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include __DIR__ . '/../../config/db.php';

        $query = "SELECT * FROM menu ORDER BY id ASC";
        $result = $conn->query($query);

        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $id         = (int) $row['id'];
            $nama       = htmlspecialchars($row['nama']);
            $deskripsi  = htmlspecialchars($row['deskripsi']);
            $bahan      = htmlspecialchars($row['bahan']);
            $harga      = number_format($row['harga'], 0, ',', '.');
            $gambar     = htmlspecialchars($row['gambar']);

            // Validasi gambar
            $gambarWebPath = "/KostIBU/assets/img/menu/$gambar";
            $gambarServerPath = $_SERVER['DOCUMENT_ROOT'] . $gambarWebPath;
            $gambarHTML = (!empty($gambar) && file_exists($gambarServerPath))
                ? "<img src='$gambarWebPath' alt='Gambar Menu' style='max-width:70px; border-radius:6px;'>"
                : "<span style='color:#dc3545; font-size:12px;'>Tidak ditemukan</span>";

            echo "
            <tr>
                <td>$no</td>
                <td>$nama</td>
                <td class='text-justify'>$deskripsi</td>
                <td class='text-justify'>$bahan</td>
                <td class='price'>Rp $harga</td>
                <td style='text-align:center;'>$gambarHTML</td>
                <td>
                    <div class='action-buttons'>
                        <a href='?page=menu/menu_edit&id=$id' class='btn btn-edit'>
                            <i class='fas fa-edit'></i> Edit
                        </a>
                        <a href='?page=menu/menu_delete&id=$id' class='btn btn-delete' onclick=\"return confirm('Yakin ingin menghapus menu ini?')\">
                            <i class='fas fa-trash-alt'></i> Hapus
                        </a>
                    </div>
                </td>
            </tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>
