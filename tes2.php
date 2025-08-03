<?php
include 'koneksi.php';

if (isset($_GET['id_mobil'])) {
    $id_mobil = $_GET['id_mobil'];
    $sql = "SELECT * FROM mobil WHERE id_mobil = '$id_mobil'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID Mobil tidak ditemukan</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Mobil - Rent Wheels</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">
                    <!-- Page header -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 text-gray-800">Edit Data Mobil</h1>
                        <a href="mobil.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left fa-sm mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">Form Edit Mobil</h6>
                        </div>
                        <div class="card-body">
                            <form action="ubah_mobil.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">ID Mobil</label>
                                            <input type="text" class="form-control bg-light" name="id_mobil" 
                                                   value="<?php echo $row['id_mobil']; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Merk</label>
                                            <input type="text" class="form-control" id="merk" name="merk" 
                                                   value="<?php echo $row['merk']; ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">No Plat</label>
                                            <input type="text" class="form-control" id="no_plat" name="no_plat" 
                                                   value="<?php echo $row['no_plat']; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Warna</label>
                                            <input type="text" class="form-control" id="warna" name="warna" 
                                                   value="<?php echo $row['warna']; ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tahun</label>
                                            <select class="form-control" id="tahun" name="tahun" required>
                                                <?php 
                                                $currentYear = date('Y');
                                                for($i = $currentYear; $i >= $currentYear-20; $i--) {
                                                    $selected = ($i == $row['tahun']) ? 'selected' : '';
                                                    echo "<option value='$i' $selected>$i</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Harga Sewa</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" class="form-control" id="harga" name="harga" 
                                                       value="<?php echo $row['harga']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="tersedia" <?php echo ($row['status'] == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                        <option value="disewa" <?php echo ($row['status'] == 'disewa') ? 'selected' : ''; ?>>Disewa</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Gambar Mobil</label>
                                    <div class="row align-items-center">
                                        <div class="col-md-3 mb-3">
                                            <img src="img/mobil/<?php echo $row['gambar']; ?>" alt="Preview" class="img-thumbnail">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="gambar" name="gambar">
                                                <label class="custom-file-label" for="gambar">Pilih file baru (opsional)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-right">
                                    <button type="reset" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo fa-sm mr-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save fa-sm mr-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // Update file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    function validateForm() {
        const merk = document.getElementById('merk').value;
        const noPlat = document.getElementById('no_plat').value;
        const warna = document.getElementById('warna').value;
        const tahun = document.getElementById('tahun').value;
        const harga = document.getElementById('harga').value;
        const status = document.getElementById('status').value;

        if (!merk || !noPlat || !warna || !tahun || !harga || !status) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Semua field harus diisi!',
                confirmButtonColor: '#4e73df'
            });
            return false;
        }

        // Submit form dengan AJAX
        const form = document.querySelector('form');
        const formData = new FormData(form);

        fetch('ubah_mobil.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status,
                title: data.status === 'success' ? 'Berhasil!' : 'Error!',
                text: data.message,
                confirmButtonColor: '#4e73df'
            }).then((result) => {
                if (data.status === 'success') {
                    window.location.href = 'mobil.php';
                }
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan: ' + error,
                confirmButtonColor: '#4e73df'
            });
        });

        return false; // Prevent traditional form submission
    }
    </script>

    <style>
    .card {
        border: none;
        border-radius: 15px;
    }

    .card-header {
        background: linear-gradient(to right, #2c3e50, #3498db);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1rem;
    }

    .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1d3e2;
        padding: 0.8rem 1rem;
        height: auto;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
        background: #f8f9fc;
        border-color: #d1d3e2;
    }

    .custom-file-label {
        border-radius: 8px;
        padding: 0.8rem 1rem;
        height: auto;
    }

    .custom-file-input:focus ~ .custom-file-label {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .btn {
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #858796 0%, #6b6d7d 100%);
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .font-weight-bold {
        color: #4e73df;
        margin-bottom: 0.5rem;
    }

    .img-thumbnail {
        border-radius: 8px;
        border: 2px solid #e3e6f0;
    }
    </style>
</body>
</html>

