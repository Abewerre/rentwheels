<?php
include 'koneksi.php';

// Fungsi untuk mendapatkan ID Mobil berikutnya
function getNextMobilId($conn) {
    $sql = "SELECT MAX(id_mobil) as max_id FROM mobil";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return ($row['max_id'] ?? 0) + 1;
}

// Fungsi untuk cek no plat
function checkPlatExists($conn, $plat) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM mobil WHERE no_plat = ?");
    $stmt->bind_param("s", $plat);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Generate ID Mobil baru
$newIdMobil = getNextMobilId($conn);

// Ajax endpoint untuk cek no plat
if(isset($_POST['check_plat'])) {
    $plat = $_POST['plat'];
    echo json_encode(['exists' => checkPlatExists($conn, $plat)]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Mobil - Rent Wheels</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="css/form_mobil.css" rel="stylesheet">
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
                        <h1 class="h3 text-gray-800">Tambah Data Mobil</h1>
                        <a href="mobil.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left fa-sm mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">Form Tambah Mobil</h6>
                        </div>
                        <div class="card-body">
                            <form action="tambah_mobil.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">ID Mobil</label>
                                            <input type="text" class="form-control bg-light" name="id_mobil" 
                                                   value="<?php echo $newIdMobil; ?>" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Merk</label>
                                            <input type="text" class="form-control" id="merk" name="merk" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">No Plat</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" class="form-control text-center" id="plat_huruf1" 
                                                       style="width: 70px; margin-right: 8px;" 
                                                       maxlength="2" placeholder="AB" required>
                                                <span class="mx-1">-</span>
                                                <input type="text" class="form-control text-center" id="plat_angka" 
                                                       style="width: 100px; margin-right: 8px;" 
                                                       maxlength="4" placeholder="1234" required>
                                                <span class="mx-1">-</span>
                                                <input type="text" class="form-control text-center" id="plat_huruf2" 
                                                       style="width: 90px;" 
                                                       maxlength="3" placeholder="XYZ" required>
                                                <input type="hidden" name="no_plat" id="no_plat">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Warna</label>
                                            <input type="text" class="form-control" id="warna" name="warna" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tahun</label>
                                            <select class="form-control" id="tahun" name="tahun" required>
                                                <option value="">Pilih Tahun</option>
                                                <?php 
                                                $currentYear = date('Y');
                                                for($i = $currentYear; $i >= $currentYear-20; $i--) {
                                                    echo "<option value='$i'>$i</option>";
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
                                                <input type="number" class="form-control" id="harga" name="harga" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Gambar Mobil</label>
                                    <div class="custom-file mb-2">
                                        <input type="file" class="custom-file-input" id="gambar" name="gambar" 
                                               accept="image/*" onchange="previewImage(this)" required>
                                        <label class="custom-file-label" for="gambar">Pilih file gambar...</label>
                                    </div>
                                    <div id="preview" class="mt-2" style="display: none;">
                                        <img id="imgPreview" class="img-thumbnail" style="max-height: 200px;">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    // Fungsi untuk mengubah ke huruf kapital dan validasi huruf
    function validateLetters(input) {
        input.value = input.value.toUpperCase().replace(/[^A-Z]/g, '');
    }

    // Fungsi untuk validasi angka
    function validateNumbers(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    // Fungsi untuk menggabungkan no plat
    function combinePlat() {
        const huruf1 = document.getElementById('plat_huruf1').value;
        const angka = document.getElementById('plat_angka').value;
        const huruf2 = document.getElementById('plat_huruf2').value;
        document.getElementById('no_plat').value = `${huruf1} ${angka} ${huruf2}`.trim();
    }

    // Event listeners untuk masing-masing input
    document.getElementById('plat_huruf1').addEventListener('input', function(e) {
        validateLetters(this);
        combinePlat();
        if(this.value.length === 2) {
            document.getElementById('plat_angka').focus();
        }
    });

    document.getElementById('plat_angka').addEventListener('input', function(e) {
        validateNumbers(this);
        combinePlat();
        if(this.value.length === 4) {
            document.getElementById('plat_huruf2').focus();
        }
    });

    document.getElementById('plat_huruf2').addEventListener('input', function(e) {
        validateLetters(this);
        combinePlat();
    });

    // Modifikasi validasi real-time untuk no plat
    let platTimeout;
    function checkPlatNumber() {
        const noPlat = document.getElementById('no_plat').value;
        clearTimeout(platTimeout);
        
        platTimeout = setTimeout(() => {
            if(noPlat.length > 0) {
                fetch('form_mobil.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'check_plat=1&plat=' + noPlat
                })
                .then(response => response.json())
                .then(data => {
                    if(data.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Plat Sudah Terdaftar',
                            text: 'Silakan masukkan no plat lain',
                            confirmButtonColor: '#4e73df'
                        });
                        document.getElementById('plat_huruf1').value = '';
                        document.getElementById('plat_angka').value = '';
                        document.getElementById('plat_huruf2').value = '';
                        document.getElementById('no_plat').value = '';
                        document.getElementById('plat_huruf1').focus();
                    }
                });
            }
        }, 500);
    }

    // Tambahkan event listener untuk pengecekan plat
    ['plat_huruf1', 'plat_angka', 'plat_huruf2'].forEach(id => {
        document.getElementById(id).addEventListener('change', checkPlatNumber);
    });

    function validateForm() {
        const huruf1 = document.getElementById('plat_huruf1').value;
        const angka = document.getElementById('plat_angka').value;
        const huruf2 = document.getElementById('plat_huruf2').value;
        
        if (!huruf1 || !angka || !huruf2) {
            showError('Semua bagian no plat harus diisi!');
            return false;
        }

        if (huruf1.length < 1 || huruf1.length > 2) {
            showError('Bagian pertama plat harus 1-2 huruf!');
            return false;
        }

        if (angka.length < 1 || angka.length > 4) {
            showError('Bagian kedua plat harus 1-4 angka!');
            return false;
        }

        if (huruf2.length < 1 || huruf2.length > 3) {
            showError('Bagian ketiga plat harus 1-3 huruf!');
            return false;
        }

        // Lanjutkan dengan validasi lainnya...
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

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const imgPreview = document.getElementById('imgPreview');
        const label = input.nextElementSibling;
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
            // Update label dengan nama file
            label.textContent = input.files[0].name;
        } else {
            imgPreview.src = '';
            preview.style.display = 'none';
            label.textContent = 'Pilih file gambar...';
        }
    }

    // Tambahkan validasi tipe file
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        
        if (!validImageTypes.includes(fileType)) {
            Swal.fire({
                icon: 'error',
                title: 'File Tidak Valid',
                text: 'Mohon pilih file gambar (JPG, JPEG, atau PNG)',
                confirmButtonColor: '#4e73df'
            });
            e.target.value = '';
            document.querySelector('.custom-file-label').textContent = 'Pilih file gambar...';
            document.getElementById('preview').style.display = 'none';
        }
    });
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

    /* Tambahkan style untuk input plat */
    .form-control.text-center {
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 1px;
        height: 45px;
    }

    .form-control.text-center::placeholder {
        font-weight: normal;
        letter-spacing: normal;
    }

    .mx-1 {
        font-weight: bold;
        font-size: 20px;
        color: #4e73df;
    }

    /* Tambahkan style untuk input file dan preview */
    .custom-file {
        position: relative;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 1rem + 2px);
        margin: 0;
        opacity: 0;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.5em + 1rem + 2px);
        padding: 0.5rem 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6e707e;
        background-color: #fff;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.5em + 1rem);
        padding: 0.5rem 1rem;
        line-height: 1.5;
        color: #fff;
        content: "Browse";
        background-color: #4e73df;
        border-left: inherit;
        border-radius: 0 0.35rem 0.35rem 0;
    }

    #preview {
        text-align: center;
        margin-top: 1rem;
        padding: 1rem;
        border: 1px dashed #d1d3e2;
        border-radius: 0.35rem;
        background-color: #f8f9fc;
    }

    #imgPreview {
        max-width: 100%;
        height: auto;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    </style>
</body>
</html> 