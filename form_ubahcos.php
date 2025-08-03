<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Customer - Rent Wheels</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid mt-4">
                    <!-- Page header -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 text-gray-800">Edit Data Customer</h1>
                        <a href="costumer.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left fa-sm mr-2"></i>Kembali
                        </a>
                    </div>

                    <?php
                    include 'koneksi.php';
                    
                    if(isset($_GET['id_customer'])) {
                        $id_customer = $_GET['id_customer'];
                        $sql = "SELECT * FROM customer WHERE id_customer = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_customer);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if($row = $result->fetch_assoc()) {
                    ?>
                    
                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">Form Edit Customer</h6>
                        </div>
                        <div class="card-body">
                            <form action="update_cos.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                <input type="hidden" name="id_customer" value="<?php echo $row['id_customer']; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">ID Customer</label>
                                            <input type="text" class="form-control bg-light" 
                                                   value="<?php echo $row['id_customer']; ?>" disabled>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Customer</label>
                                            <input type="text" class="form-control" id="nama_customer" name="nama_customer" 
                                                   value="<?php echo htmlspecialchars($row['nama_customer']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="Laki-laki" <?php if($row['gender'] == 'Laki-laki') echo 'selected'; ?>>
                                                    Laki-laki
                                                </option>
                                                <option value="Perempuan" <?php if($row['gender'] == 'Perempuan') echo 'selected'; ?>>
                                                    Perempuan
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">No Telpon</label>
                                            <input type="text" class="form-control" id="no_telpon" name="no_telpon" 
                                                   value="<?php echo htmlspecialchars($row['no_telpon']); ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="4" required><?php 
                                                echo htmlspecialchars($row['alamat']); 
                                            ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold" for="foto_identitas">Foto Identitas (KTP/SIM)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto_identitas" name="foto_identitas" accept="image/*">
                                                <label class="custom-file-label" for="foto_identitas">Pilih file gambar...</label>
                                            </div>
                                        </div>
                                        <div id="preview_foto_identitas" class="mt-2">
                                            <?php if (!empty($row['foto_identitas'])): ?>
                                                <span class="text-muted">Foto identitas saat ini:</span><br>
                                                <img src="uploads/<?= htmlspecialchars($row['foto_identitas']) ?>" alt="Foto Identitas" style="max-width:120px;max-height:120px;border-radius:8px;border:1px solid #ccc;">
                                            <?php endif; ?>
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
                    
                    <?php
                        } else {
                            echo "<div class='alert alert-danger rounded-pill shadow-sm'>Data customer tidak ditemukan</div>";
                        }
                        $stmt->close();
                    } else {
                        echo "<div class='alert alert-danger rounded-pill shadow-sm'>ID Customer tidak ditemukan</div>";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function validateForm() {
        const nama = document.getElementById('nama_customer').value;
        const noTelp = document.getElementById('no_telpon').value;
        const alamat = document.getElementById('alamat').value;

        if (!nama || /^\d+$/.test(nama)) {
            showError('Nama Customer tidak valid!');
            return false;
        }

        if (!noTelp || !/^\d+$/.test(noTelp)) {
            showError('No Telpon harus berupa angka!');
            return false;
        }

        if (noTelp.length < 10 || noTelp.length > 13) {
            showError('No Telpon harus 10-13 digit!');
            return false;
        }

        if (!alamat) {
            showError('Alamat tidak boleh kosong!');
            return false;
        }

        return true;
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
            confirmButtonColor: '#4e73df',
            confirmButtonText: 'OK'
        });
    }

    document.getElementById('foto_identitas').addEventListener('change', function(e) {
        const preview = document.getElementById('preview_foto_identitas');
        preview.innerHTML = '';
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                preview.innerHTML = '<img src="' + ev.target.result + '" alt="Preview" style="max-width:140px;max-height:140px;border-radius:8px;border:1px solid #ccc;">';
            };
            reader.readAsDataURL(file);
        }
        // Update label
        var label = e.target.nextElementSibling;
        if (file) label.innerText = file.name;
        else label.innerText = 'Pilih file gambar...';
    });
    </script>

    <style>
    .card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
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
        transition: all 0.2s;
    }

    .form-control:focus {
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

    textarea {
        resize: none;
    }

    .alert {
        padding: 1rem 1.5rem;
        border: none;
    }

    .bg-light {
        background-color: #f8f9fc !important;
    }
    </style>
</body>
</html>