<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mobil = $_POST['id_mobil'];
    $merk = $_POST['merk'];
    $no_plat = $_POST['no_plat'];
    $warna = $_POST['warna'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    // Cek apakah ada file gambar yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        $upload_dir = "img/mobil/";
        
        // Hapus gambar lama
        $sql_old = "SELECT gambar FROM mobil WHERE id_mobil = ?";
        $stmt_old = $conn->prepare($sql_old);
        $stmt_old->bind_param("s", $id_mobil);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();
        $row_old = $result_old->fetch_assoc();
        
        if ($row_old['gambar'] && file_exists($upload_dir . $row_old['gambar'])) {
            unlink($upload_dir . $row_old['gambar']);
        }
        
        // Upload gambar baru
        $file_extension = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
        $new_filename = $id_mobil . '_' . date('YmdHis') . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Update data dengan gambar baru
            $sql = "UPDATE mobil SET merk=?, no_plat=?, warna=?, tahun=?, harga=?, status=?, gambar=? WHERE id_mobil=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $merk, $no_plat, $warna, $tahun, $harga, $status, $new_filename, $id_mobil);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal mengupload gambar'
            ]);
            exit;
        }
    } else {
        // Update data tanpa mengubah gambar
        $sql = "UPDATE mobil SET merk=?, no_plat=?, warna=?, tahun=?, harga=?, status=? WHERE id_mobil=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $merk, $no_plat, $warna, $tahun, $harga, $status, $id_mobil);
    }
    
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data mobil berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui data: ' . $conn->error
        ]);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proses Update Mobil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    // Tangkap response JSON
    <?php if(isset($response)): ?>
        Swal.fire({
            icon: '<?php echo $response["status"]; ?>',
            title: '<?php echo $response["status"] == "success" ? "Berhasil!" : "Error!"; ?>',
            text: '<?php echo $response["message"]; ?>',
            confirmButtonColor: '#4e73df'
        }).then((result) => {
            window.location.href = 'mobil.php';
        });
    <?php endif; ?>
    </script>
</body>
</html>

