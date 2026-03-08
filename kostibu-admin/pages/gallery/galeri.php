<h2>Data Pin Map</h2>


<!-- Tabel Data Pin -->
<div class="table-responsive">
    <table class="table-data">
        <thead>
            <tr>
                <th>NO</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Posisi X</th>
                <th>Posisi Y</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Koneksi
        include __DIR__ . '/../../config/db.php';

        // Query
        $query = "SELECT * FROM map_pins ORDER BY id ASC";
        $result = $conn->query($query);

        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $id          = (int) $row['id'];
            $title       = htmlspecialchars($row['title']);
            $description = htmlspecialchars($row['description']);
            $pos_x       = (int) $row['pos_x'];
            $pos_y       = (int) $row['pos_y'];

            // Pecah images jadi array
            $images = [];
            if (!empty($row['images'])) {
                $images = explode(',', $row['images']);
            }

            $firstImage = (!empty($images)) ? trim($images[0]) : null;

            // Path URL & server
            $gambarWebPath = "/KostIBU/assets/img/gallery/$firstImage";
            $gambarServerPath = $_SERVER['DOCUMENT_ROOT'] . $gambarWebPath;

            // Validasi file exist
            $gambarHTML = ($firstImage && file_exists($gambarServerPath))
                ? "<img src='$gambarWebPath' alt='Gambar Pin' style='max-width:70px; border-radius:6px;'>"
                : "<span style='color:#dc3545; font-size:12px;'>Tidak ditemukan</span>";

            echo "
            <tr>
                <td>$no</td>
                <td>$title</td>
                <td class='text-justify'>$description</td>
                <td>$pos_x</td>
                <td>$pos_y</td>
                <td style='text-align:center;'>$gambarHTML</td>
                <td>
                    <div class='action-buttons'>
                        <a href='?page=gallery/galeri_edit&id=$id' class='btn btn-edit'>
                            <i class='fas fa-edit'></i> Edit
                        </a>
                    </div>
                </td>
            </tr>
            ";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>
