<?php
include 'koneksi.php';

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['no_ktp'])) {
    $no_ktp = $_GET['no_ktp'];

    // Dapatkan id_sewa terakhir
    $sql = "SELECT id_sewa FROM sewa ORDER BY id_sewa DESC LIMIT 1";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query Error: " . $conn->error);
    }
    $last_id_sewa = $result->fetch_assoc()['id_sewa'];

    // Tentukan id_sewa baru
    if ($last_id_sewa) {
        $new_id_sewa = 'S' . str_pad((int)substr($last_id_sewa, 1) + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $new_id_sewa = 'S001';
    }

    // Masukkan data ke tabel sewa
    $sql = "INSERT INTO sewa (id_sewa, id_customer) VALUES ('$new_id_sewa', '$no_ktp')";
    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, arahkan kembali ke costumer.php dengan pesan sukses
        header("Location: costumer.php?status=success");
    } else {
        // Jika terjadi kesalahan, arahkan kembali ke costumer.php dengan pesan error
        header("Location: costumer.php?status=error");
    }

    $conn->close();
    exit();
}
?>