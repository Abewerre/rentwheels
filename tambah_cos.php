<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Data Customer</title>
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    // Array untuk menyimpan pesan error
    $errors = [];

    // Validasi ID Customer
    if (!is_numeric($id_customer)) {
        $errors[] = 'ID Customer harus berupa angka';
    }

    // Validasi nomor telepon
    if (!is_numeric($no_telpon)) {
        $errors[] = 'Nomor telepon harus berupa angka';
    }
    if (strlen($no_telpon) > 15) {
        $errors[] = 'Nomor telepon tidak boleh lebih dari 15 digit';
    }

    // Validasi panjang alamat
    if (strlen($alamat) > 50) {
        $errors[] = 'Alamat terlalu panjang (maksimal 50 karakter)';
    }

    // Validasi upload foto identitas
    if (!isset($_FILES['foto_identitas']) || $_FILES['foto_identitas']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Foto identitas wajib diupload';
    } else {
        $foto = $_FILES['foto_identitas'];
        $allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!in_array($foto['type'], $allowed)) {
            $errors[] = 'File identitas harus berupa gambar (jpg, jpeg, png, webp)';
        }
        if ($foto['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran file maksimal 2MB';
        }
    }

    // Cek apakah ada error
    if (!empty($errors)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error!',
                html: '" . implode("<br>", $errors) . "',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
        exit;
    }

    // Proses upload file
    $foto_nama = '';
    if (isset($_FILES['foto_identitas']) && $_FILES['foto_identitas']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto_identitas']['name'], PATHINFO_EXTENSION);
        $foto_nama = 'id' . $id_customer . '_' . time() . '.' . $ext;
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $upload_path = $upload_dir . $foto_nama;
        if (!move_uploaded_file($_FILES['foto_identitas']['tmp_name'], $upload_path)) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Gagal!',
                    text: 'Gagal upload foto identitas',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    window.history.back();
                });
            </script>";
            exit;
        }
    }

    // Insert data
    $sql = "INSERT INTO customer (id_customer, nama_customer, gender, no_telpon, alamat, foto_identitas) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $id_customer, $nama_customer, $gender, $no_telpon, $alamat, $foto_nama);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data customer berhasil ditambahkan',
                        confirmButtonColor: '#4e73df'
                    }).then((result) => {
                        window.location.href = 'costumer.php';
                    });
                });
              </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan! Silakan coba lagi',
                        confirmButtonColor: '#4e73df'
                    }).then((result) => {
                        window.location.href = 'form_costumer.php';
                    });
                });
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>

</body>
</html>