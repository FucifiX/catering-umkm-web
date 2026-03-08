<h2>Data Pesan Kontak</h2>

<!-- Tabel Data Pesan Kontak -->
<div class="table-responsive">
    <table class="table-data">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Subjek</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include __DIR__ . '/../../config/db.php';

        $query = "SELECT * FROM contact_messages ORDER BY id ASC";
        $result = $conn->query($query);

        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $id         = (int) $row['id'];
            $name       = htmlspecialchars($row['name']);
            $email      = htmlspecialchars($row['email']);
            $subject    = htmlspecialchars($row['subject']);
            $message    = nl2br(htmlspecialchars($row['message']));
            $created_at = htmlspecialchars($row['created_at']);

            echo "
            <tr>
                <td>$no</td>
                <td>$name</td>
                <td>$email</td>
                <td>$subject</td>
                <td class='text-justify'>$message</td>
                <td>$created_at</td>
                <td>
                    <div class='action-buttons'>
                        <a href='?page=message/delete_message&id=$id' class='btn btn-delete' onclick=\"return confirm('Yakin ingin menghapus pesan ini?')\">
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
