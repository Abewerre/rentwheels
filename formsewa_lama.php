<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rent Wheels - Kelola customer</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/form_mobil.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                </div>
                <div class="sidebar-brand-text mx-3">RENT WHEELS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
           

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
             
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="costumer.php">
                    <i class="bi bi-person-circle"></i>
                    <span> kelola costumer</span>
                </a>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="mobil.php">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Kelola mobil</span>
                </a>   
            </li>
            
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Sewa dan Pengembalian</span>

    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"

        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="sewa.php">Sewa</a>
            <a class="collapse-item" href="kembali.php">Pengembalian</a>
        </div>
    </div>
</li>
            <li class="nav-item">
            
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="laporan.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<li class="nav-item">
    <a class="nav-link" href="login.php" onclick="return confirmLogout()">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span></a>
<hr class="sidebar-divider d-none d-md-block">

<script>
function confirmLogout() {
return confirm("Apakah Anda yakin ingin logout?");
}
</script>

            <!-- Sidebar Toggler (Sidebar) -->
          
            <!-- Sidebar Message -->
          

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                  

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - User Information -->


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Data Sewa Mobil</h1>
                        <a href="sewa.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="bi bi-arrow-left-circle-fill"></i> Kembali</a>
                    </div>
                    <div>
                        <div>
                            <div>
                            <?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'rental';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil data dari tabel mobil
$sqlMobil = 'SELECT id_mobil, warna, gambar, harga FROM mobil';
$stmtMobil = $pdo->prepare($sqlMobil);
$stmtMobil->execute();
$mobils = $stmtMobil->fetchAll(PDO::FETCH_ASSOC);

// Ambil data dari tabel customer
$sqlCustomer = 'SELECT id_customer, nama_customer FROM customer';
$stmtCustomer = $pdo->prepare($sqlCustomer);
$stmtCustomer->execute();
$customers = $stmtCustomer->fetchAll(PDO::FETCH_ASSOC);

// Proses penyimpanan data ke tabel sewa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sewa = $_POST['id_sewa'];
    $id_mobil = $_POST['id_mobil'];
    $id_customer = $_POST['id_customer'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $harga = $_POST['harga'];

    // Cek apakah id_mobil sudah ada di tabel sewa
    $sqlCheckMobil = 'SELECT COUNT(*) FROM sewa WHERE id_mobil = ?';
    $stmtCheckMobil = $pdo->prepare($sqlCheckMobil);
    $stmtCheckMobil->execute([$id_mobil]);
    $count = $stmtCheckMobil->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Mobil sedang di pakai!');</script>";
    } else {
        // Tambahkan semua kolom yang diperlukan dengan nilai default
        $sqlSewa = 'INSERT INTO sewa (id_sewa, id_mobil, id_customer, tlg_sewa, tgl_kembali, harga, denda, bayar, uang_kembali, tgl_pengembalian) 
                    VALUES (?, ?, ?, ?, ?, ?, 0, 0, 0, NULL)';
        $stmtSewa = $pdo->prepare($sqlSewa);
        $stmtSewa->execute([$id_sewa, $id_mobil, $id_customer, $tanggal_sewa, $tanggal_kembali, $harga]);
    
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='sewa.php';</script>";
    }
}
?>

<div class="container">
    
    <form action="formsewa.php" method="POST">
    <div class="form-group">
            <label for="id_sewa">ID Sewa:</label>
            <input type="text" class="form-control" name="id_sewa" id="id_sewa" required oninvalid="this.setCustomValidity('Harap isi ID Sewa')" oninput="this.setCustomValidity('')">
        </div>

        <div class="form-group">
            <label for="id_mobil">ID Mobil:</label>
            <select class="form-control" name="id_mobil" id="id_mobil" onchange="updateMobilDetails()">
                <?php foreach ($mobils as $mobil) : ?>
                    <option value="<?php echo $mobil['id_mobil']; ?>"><?php echo $mobil['id_mobil']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="text" class="form-control" name="harga" id="harga" readonly>
        </div>

        <div class="form-group">
            <label for="warna">Warna:</label>
            <input type="text" class="form-control" name="warna" id="warna" readonly>
        </div>

        <div class="form-group">
             <label for="id_customer">ID Customer:</label>
             <select class="form-control" name="id_customer" id="id_customer">
               <?php foreach ($customers as $customer) : ?>
                    <option value="<?php echo $customer['id_customer']; ?>"><?php echo $customer['id_customer']; ?></option>
              <?php endforeach; ?>
             </select>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <div>
                <img id="gambar" src="" alt="Gambar Mobil" width="100">
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_sewa">Tanggal Sewa:</label>
            <input type="date" class="form-control" name="tanggal_sewa" id="tanggal_sewa" required 
                oninvalid="this.setCustomValidity('Harap isi Tanggal Sewa')" 
                oninput="this.setCustomValidity('')">
        </div>

        <div class="form-group">
            <label for="tanggal_kembali">Tanggal Kembali:</label>
            <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali" required 
                oninvalid="this.setCustomValidity('Harap isi Tanggal Kembali')" 
                oninput="this.setCustomValidity('')">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
function updateMobilDetails() {
    var id_mobil = document.getElementById('id_mobil').value;
    var mobils = <?php echo json_encode($mobils); ?>;
    var selectedMobil = mobils.find(mobil => mobil.id_mobil == id_mobil);
    if (selectedMobil) {
        document.getElementById('warna').value = selectedMobil.warna;
        document.getElementById('gambar').src = 'uploads/' + selectedMobil.gambar;
        document.getElementById('harga').value = selectedMobil.harga;
    }
}

// Memanggil updateMobilDetails saat halaman dimuat untuk mengatur nilai default
document.addEventListener('DOMContentLoaded', (event) => {
    updateMobilDetails();
});

// Validasi tanggal
document.getElementById('tanggal_kembali').addEventListener('change', function() {
    var tanggalSewa = new Date(document.getElementById('tanggal_sewa').value);
    var tanggalKembali = new Date(this.value);
    if (tanggalKembali < tanggalSewa) {
        alert('Tanggal kembali tidak boleh sebelum tanggal sewa!');
        this.value = ''; // Reset tanggal kembali
    }
});
</script>                   
                            
                            </div>
                            
                            

