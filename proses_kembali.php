<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sewa = $_POST['id_sewa'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $jam_pengembalian = isset($_POST['jam_pengembalian']) ? $_POST['jam_pengembalian'] : null;
    $denda = $_POST['denda'];
    $total_bayar = $_POST['bayar'];

    // Mulai transaction
    $conn->begin_transaction();

    try {
        // Update data sewa
        $sql = "UPDATE sewa 
                SET status = 'Selesai',
                    tgl_pengembalian = ?,
                    jam_pengembalian = ?,
                    denda = ? 
                WHERE id_sewa = ? 
                AND (status = 'Tidak Selesai' OR status IS NULL)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $tgl_pengembalian, $jam_pengembalian, $denda, $id_sewa);
        
        if ($stmt->execute()) {
            // Update status mobil menjadi tersedia
            $sql_mobil = "UPDATE mobil m 
                          JOIN sewa s ON m.id_mobil = s.id_mobil 
                          SET m.status = 'Tersedia' 
                          WHERE s.id_sewa = ?";
            $stmt_mobil = $conn->prepare($sql_mobil);
            $stmt_mobil->bind_param("s", $id_sewa);
            $stmt_mobil->execute();
            
            $conn->commit();
            echo "success";
        } else {
            throw new Exception("Gagal memproses pengembalian");
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = 'kembali.php';
              </script>";
    }
    
    $stmt->close();
    $stmt_mobil->close();
} else {
    header("Location: kembali.php");
}

$conn->close();
?> 