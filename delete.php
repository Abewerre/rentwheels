<?php
include 'koneksi.php';

if (isset($_GET['id_sewa'])) {
  $id_sewa = $_GET['id_sewa'];

  // Query untuk menghapus data customer berdasarkan id_customer
  $sql = "DELETE FROM sewa WHERE id_sewa = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $id_sewa);

  if ($stmt->execute()) {
      echo "<script>
              alert('laporan berhasil di download.');
              window.location.href='laporan.php';
            </script>";
  } else {
      echo "<script>
              alert('Terjadi kesalahan saat menghapus data customer: " . $conn->error . "');
              window.location.href='laporan.php';
            </script>";
  }

  $stmt->close();
  $conn->close();
} else {
  echo "<script>
          alert('ID Sewa tidak ditemukan.');
          window.location.href='laporan.php';
        </script>";
}
?>