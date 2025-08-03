<!DOCTYPE html>
<html>
<head>
    <title>Update Data</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_customer = $_POST['id_customer'];
    $nama_customer = $_POST['nama_customer'];
    $gender = $_POST['gender'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];

    // Cek apakah ada file baru diupload
    $foto_nama = '';
    $update_foto = false;
    if (isset($_FILES['foto_identitas']) && $_FILES['foto_identitas']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto_identitas'];
        $allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($foto['type'], $allowed)) {
            echo "<script>Swal.fire({icon:'error',title:'File tidak valid',text:'File identitas harus berupa gambar (jpg, jpeg, png, webp)'}).then(()=>{window.history.back();});</script>";
            exit;
        }
        if ($foto['size'] > 2 * 1024 * 1024) {
            echo "<script>Swal.fire({icon:'error',title:'File terlalu besar',text:'Ukuran file maksimal 2MB'}).then(()=>{window.history.back();});</script>";
            exit;
        }
        // Ambil nama file lama
        $sqlOld = "SELECT foto_identitas FROM customer WHERE id_customer = ?";
        $stmtOld = $conn->prepare($sqlOld);
        $stmtOld->bind_param("i", $id_customer);
        $stmtOld->execute();
        $resultOld = $stmtOld->get_result();
        if ($rowOld = $resultOld->fetch_assoc()) {
            if (!empty($rowOld['foto_identitas']) && file_exists('uploads/' . $rowOld['foto_identitas'])) {
                @unlink('uploads/' . $rowOld['foto_identitas']);
            }
        }
        $stmtOld->close();
        // Upload file baru
        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $foto_nama = 'id' . $id_customer . '_' . time() . '.' . $ext;
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $upload_path = $upload_dir . $foto_nama;
        if (!move_uploaded_file($foto['tmp_name'], $upload_path)) {
            echo "<script>Swal.fire({icon:'error',title:'Upload Gagal',text:'Gagal upload foto identitas'}).then(()=>{window.history.back();});</script>";
            exit;
        }
        $update_foto = true;
    }

    if ($update_foto) {
        $sql = "UPDATE customer SET 
                nama_customer = ?, 
                gender = ?, 
                no_telpon = ?, 
                alamat = ?,
                foto_identitas = ?
                WHERE id_customer = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nama_customer, $gender, $no_telpon, $alamat, $foto_nama, $id_customer);
    } else {
        $sql = "UPDATE customer SET 
                nama_customer = ?, 
                gender = ?, 
                no_telpon = ?, 
                alamat = ? 
                WHERE id_customer = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama_customer, $gender, $no_telpon, $alamat, $id_customer);
    }

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data customer berhasil diperbarui',
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
                text: 'Gagal memperbarui data: " . $stmt->error . "',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html> 