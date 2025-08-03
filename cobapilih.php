
<?php
include 'koneksi.php';

// Generate new ID Sewa
$sql = "SELECT MAX(id_sewa) AS max_id FROM sewa";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$max_id = $row['max_id'];
$new_id = 'S' . str_pad((int)substr($max_id, 1) + 1, 3, '0', STR_PAD_LEFT);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pilih'])) {
    $no_ktp = $_POST['no_ktp'];
    $sql = "SELECT nama_pelanggan FROM pelanggan WHERE no_ktp = '$no_ktp'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $nama_pelanggan = $row['nama_pelanggan'];
}
?>

<!-- Form to select customer -->
<form method="post" action="">
    <label for="no_ktp">No KTP:</label>
    <input type="text" id="no_ktp" name="no_ktp" required>
    <button type="submit" name="pilih" class="btn btn-success btn-sm">Pilih</button>
</form>

<!-- Display selected customer data -->
<?php if (isset($nama_pelanggan)): ?>
    <p>ID Sewa: <?php echo $new_id; ?></p>
    <p>Nama Pelanggan: <?php echo $nama_pelanggan; ?></p>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Sewa</th>
            <th>Nama Pelanggan</th>
            <th>ID Mobil</th>
            <th>Nama Mobil</th>
            <th>Gambar</th>
            <th>Tanggal Sewa</th>
            <th>Tanggal Kembali</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- tampilan tabel dari database -->
        <?php
        $sql = "SELECT id_sewa, id_customer, id_mobil, harga, denda, tgl_pengembalian, tgl_kembali FROM sewa";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error: " . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id_sewa"] . "</td><td>" . $row["id_customer"] . "</td><td>" . $row["id_mobil"] . "</td><td>" . $row["harga"] . "</td><td>" . $row["denda"] . "</td><td>" . $row["tgl_pengembalian"] . "</td><td>" . $row["tgl_kembali"] . "</td>";
                    echo "<td><a class='btn btn-danger btn-sm' href='hapus_sewa.php?id_sewa=" . $row["id_sewa"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a> <a class='btn btn-success btn-sm' href='pilih_sewa.php'>Pilih</a> <a class='btn btn-warning btn-sm' href='form_ubah_sewa.php?id_sewa=" . $row["id_sewa"] . "'>Ubah</a></td></tr>";
                }
            } else {
                echo "0 results";
            }
        }

        $conn->close();
        ?>
    </tbody>
</table>