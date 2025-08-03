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
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="mobil.php">
                    <i class="bi bi-person-circle"></i>
                    <span> kelola costumer</span>
                </a>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="buttons.html">
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
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
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
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>

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
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

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
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kelola Data Costumer</h1>
                        <a href="kembali.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Kembali</a>
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

// Ambil data dari tabel pelanggan
$sqlPelanggan = 'SELECT no_ktp FROM pelanggan';
$stmtPelanggan = $pdo->prepare($sqlPelanggan);
$stmtPelanggan->execute();
$pelanggans = $stmtPelanggan->fetchAll(PDO::FETCH_ASSOC);

$sqlSewa = 'SELECT id_sewa FROM sewa';
$stmtSewa = $pdo->prepare($sqlSewa);
$stmtSewa->execute();
$sewas = $stmtSewa->fetchAll(PDO::FETCH_ASSOC);

// Proses penyimpanan data ke tabel sewa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sewa = $_POST['id_sewa'];
    $id_mobil = $_POST['id_mobil'];
    $no_ktp = $_POST['no_ktp'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $harga = $_POST['harga'];

    // Hitung denda jika tgl_pengembalian melebihi tanggal_kembali
    $denda = 0;
    if (strtotime($tgl_pengembalian) > strtotime($tanggal_kembali)) {
        $days_late = (strtotime($tgl_pengembalian) - strtotime($tanggal_kembali)) / (60 * 60 * 24);
        $denda = $days_late * $harga * 2;
    }

    $sqlSewa = 'UPDATE sewa SET id_mobil = ?, id_customer = ?, tlg_sewa = ?, tgl_kembali = ?, tgl_pengembalian = ?, harga = ?, denda = ? WHERE id_sewa = ?';
    $stmtSewa = $pdo->prepare($sqlSewa);
    $stmtSewa->execute([$id_mobil, $no_ktp, $tanggal_sewa, $tanggal_kembali, $tgl_pengembalian, $harga, $denda, $id_sewa]);

    echo "Data berhasil diperbarui!";
}
?>


    <h1>Form Data Mobil</h1>
    <form action="formsewa.php" method="POST">
                            <div class="form-group">
                                <label for="id_sewa">ID Sewa:</label>
                                <select class="form-control" name="id_sewa" id="id_sewa">
                                    <?php foreach ($sewas as $sewa) : ?>
                                        <option value="<?php echo $sewa['id_sewa']; ?>"><?php echo $sewa['id_sewa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                                <label for="no_ktp">No KTP:</label>
                                <select class="form-control" name="no_ktp" id="no_ktp">
                                    <?php foreach ($pelanggans as $pelanggan) : ?>
                                        <option value="<?php echo $pelanggan['no_ktp']; ?>"><?php echo $pelanggan['no_ktp']; ?></option>
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
                                <input type="date" class="form-control" name="tanggal_sewa" id="tanggal_sewa" required>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_kembali">Tanggal Kembali:</label>
                                <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali" required>
                            </div>

                            <div class="form-group">
                                <label for="tgl_pengembalian">Tanggal Pengembalian:</label>
                                <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

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

                        document.addEventListener('DOMContentLoaded', (event) => {
                            updateMobilDetails();
                        });
                        </script>
                               
                            
                            </div>
                            
                            

