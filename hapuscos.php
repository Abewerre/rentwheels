<!DOCTYPE html>
<html>
<head>
    <title>Hapus Data</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
include 'koneksi.php';

if (isset($_GET['id_customer'])) {
  $id_customer = $_GET['id_customer'];

  // Query untuk menghapus data customer berdasarkan id_customer
  $sql = "DELETE FROM customer WHERE id_customer = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_customer);

  if ($stmt->execute()) {
      echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data customer berhasil dihapus',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'costumer.php';
                }
            });
        </script>";
  } else {
      echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal menghapus data',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'costumer.php';
                }
            });
        </script>";
  }

  $stmt->close();
  $conn->close();
} else {
  echo "<script>
          alert('ID Customer tidak ditemukan.');
          window.location.href='costumer.php';
        </script>";
}
?>

</body>
</html>