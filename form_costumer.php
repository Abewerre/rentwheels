<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan ID Customer berikutnya
function getNextCustomerId($conn) {
    $sql = "SELECT MAX(id_customer) as max_id FROM customer";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return ($row['max_id'] ?? 0) + 1;
}

// Fungsi untuk cek no telpon
function checkPhoneExists($conn, $phone) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM customer WHERE no_telpon = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Generate ID Customer baru
$newIdCustomer = getNextCustomerId($conn);

// Ajax endpoint untuk cek no telpon
if(isset($_POST['check_phone'])) {
    $phone = $_POST['phone'];
    echo json_encode(['exists' => checkPhoneExists($conn, $phone)]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Customer - Rent Wheels</title>

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
                        <h1 class="h3 text-gray-800">Tambah Data Customer</h1>
                        <a href="costumer.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left fa-sm mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">Form Customer</h6>
                        </div>
                        <div class="card-body">
                            <form action="tambah_cos.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">ID Customer</label>
                                            <input type="text" class="form-control bg-light" name="id_customer"
                                                   value="<?php echo $newIdCustomer; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Customer</label>
                                            <input type="text" class="form-control" id="nama_customer" 
                                                   name="nama_customer" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="">Pilih Gender</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">No Telpon</label>
                                            <input type="text" class="form-control" id="no_telpon" 
                                                   name="no_telpon" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" 
                                                      rows="4" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold" for="foto_identitas">Foto Identitas (KTP/SIM)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="foto_identitas" name="foto_identitas" accept="image/*" required>
                                                <label class="custom-file-label" for="foto_identitas">Pilih file gambar...</label>
                                            </div>
                                            <div id="preview_foto_identitas" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 text-right">
                                    <button type="reset" class="btn btn-secondary mr-2">
                                        <i class="fas fa-undo fa-sm mr-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save fa-sm mr-2"></i>Simpan
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
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    let phoneTimeout;

    document.getElementById('no_telpon').addEventListener('input', function(e) {
        clearTimeout(phoneTimeout);
        const phone = e.target.value;
        
        phoneTimeout = setTimeout(() => {
            if(phone.length >= 10 && phone.length <= 13) {
                fetch('form_costumer.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'check_phone=1&phone=' + phone
                })
                .then(response => response.json())
                .then(data => {
                    if(data.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Nomor Telpon Sudah Terdaftar',
                            text: 'Silakan gunakan nomor telpon lain',
                            confirmButtonColor: '#4e73df'
                        });
                        e.target.value = '';
                    }
                });
            }
        }, 500);
    });

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

        // Validasi final untuk no telpon
        return new Promise((resolve) => {
            fetch('form_costumer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'check_phone=1&phone=' + noTelp
            })
            .then(response => response.json())
            .then(data => {
                if(data.exists) {
                    showError('Nomor Telpon sudah terdaftar!');
                    resolve(false);
                } else {
                    resolve(true);
                }
            });
        });
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

    .bg-light {
        background-color: #f8f9fc !important;
    }
    </style>
</body>
</html>
