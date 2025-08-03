<?php
include 'koneksi.php';

if(isset($_GET['id_sewa'])) {
    try {
        $conn->begin_transaction();
        
        $id_sewa = $_GET['id_sewa'];
        
        // Ambil id_mobil dari data sewa yang akan dihapus
        $sql_get_mobil = "SELECT id_mobil FROM sewa WHERE id_sewa = ?";
        $stmt_get = $conn->prepare($sql_get_mobil);
        $stmt_get->bind_param("s", $id_sewa);
        $stmt_get->execute();
        $result = $stmt_get->get_result();
        $row = $result->fetch_assoc();
        $id_mobil = $row['id_mobil'];
        
        // Update status mobil menjadi Tersedia
        if($id_mobil) {
            $sql_update = "UPDATE mobil SET status = 'Tersedia' WHERE id_mobil = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("s", $id_mobil);
            $stmt_update->execute();
        }
        
        // Hapus data sewa
        $sql_delete = "DELETE FROM sewa WHERE id_sewa = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $id_sewa);
        $stmt_delete->execute();
        
        $conn->commit();
        
        echo "<script>
            window.location.href = 'sewa.php';
        </script>";
        
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
            alert('Terjadi kesalahan: " . $e->getMessage() . "');
            window.location.href = 'sewa.php';
        </script>";
    }
} else {
  echo "<script>
          alert('ID Sewa tidak ditemukan.');
          window.location.href='sewa.php';
        </script>";
}
?>