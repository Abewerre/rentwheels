<!DOCTYPE html>
<html>
<head>
    <title>Proses Tambah Mobil</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>

<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_mobil = $_POST['id_mobil'];
    $merk = $_POST['merk'];
    $no_plat = $_POST['no_plat'];
    $warna = $_POST['warna'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = 'tersedia';
    
    // Proses upload gambar
    $upload_dir = "img/mobil/"; // Sesuaikan dengan struktur folder Anda
    
    // Buat direktori jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Ambil informasi file
    $file_name = $_FILES["gambar"]["name"];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validasi ekstensi file
    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
    if (!in_array($file_extension, $allowed_extensions)) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Format file tidak didukung! Gunakan JPG, JPEG, PNG, GIF, atau WEBP',
                confirmButtonColor: '#4e73df'
            }).then((result) => {
                window.location.href = 'form_mobil.php';
            });
        </script>
        <?php
        exit();
    }
    
    // Generate nama file unik
    $unique_filename = $id_mobil . '_' . date('YmdHis') . '.' . $file_extension;
    $target_file = $upload_dir . $unique_filename;
    
    // Debug info
    error_log("Upload path: " . realpath($upload_dir));
    error_log("Target file: " . $target_file);
    
    // Cek dan proses upload
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // File berhasil diupload, masukkan data ke database
        $sql = "INSERT INTO mobil (id_mobil, merk, no_plat, warna, tahun, harga, gambar, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $id_mobil, $merk, $no_plat, $warna, $tahun, $harga, $unique_filename, $status);
        
        if ($stmt->execute()) {
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data mobil berhasil ditambahkan',
                    confirmButtonColor: '#4e73df'
                }).then((result) => {
                    window.location.href = 'mobil.php';
                });
            </script>
            <?php
        } else {
            unlink($target_file); // Hapus file jika gagal insert ke database
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal menambahkan data mobil: <?php echo $conn->error; ?>',
                    confirmButtonColor: '#4e73df'
                }).then((result) => {
                    window.location.href = 'form_mobil.php';
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal mengupload gambar. Error: <?php echo error_get_last()["message"]; ?>',
                confirmButtonColor: '#4e73df'
            }).then((result) => {
                window.location.href = 'form_mobil.php';
            });
        </script>
        <?php
    }
}
?>

</body>
</html>




