<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_mobil = $_GET['id'];

    // Query untuk menghapus data mobil berdasarkan ID
    $sql = "DELETE FROM mobil WHERE id_mobil = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_mobil);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data mobil berhasil dihapus.');
                window.location.href='mobil.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat menghapus data mobil: " . $conn->error . "');
                window.location.href='mobil.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('ID mobil tidak ditemukan.');
            window.location.href='mobil.php';
          </script>";
}
?>