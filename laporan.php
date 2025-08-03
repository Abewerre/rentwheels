<?php
include 'koneksi.php';

// Filter berdasarkan status dan search
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query dengan filter
$sql = "SELECT s.*, 
        c.nama_customer, 
        m.merk, 
        m.no_plat 
        FROM sewa s 
        LEFT JOIN customer c ON s.id_customer = c.id_customer 
        LEFT JOIN mobil m ON s.id_mobil = m.id_mobil 
        WHERE 1=1";

// Tambahkan filter status jika dipilih
if (!empty($status_filter)) {
    $sql .= " AND s.status = '$status_filter'";
}

// Tambahkan filter pencarian jika ada
if (!empty($search)) {
    $sql .= " AND (s.id_sewa LIKE '%$search%' 
              OR c.nama_customer LIKE '%$search%' 
              OR m.merk LIKE '%$search%'
              OR m.no_plat LIKE '%$search%')";
}

$sql .= " ORDER BY s.tlg_sewa DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rent Wheels - Kelola Pelanggan</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-car-side"></i>
                </div>
                <div class="sidebar-brand-text mx-3">RENT WHEELS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <hr class="sidebar-divider">

            <!-- Kelola Customer -->
            <li class="nav-item">
                <a class="nav-link" href="costumer.php">
                    <i class="bi bi-person-circle"></i>
                    <span>Kelola Customer</span>
                </a>
            </li>

            <!-- Kelola Mobil -->
            <li class="nav-item">
                <a class="nav-link" href="mobil.php">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Kelola Mobil</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Sewa -->
            <li class="nav-item">
                <a class="nav-link" href="sewa.php">
                    <i class="fas fa-fw fa-dollar-sign"></i>
                    <span>Sewa</span>
                </a>
            </li>

            <!-- Pengembalian -->
            <li class="nav-item">
                <a class="nav-link" href="kembali.php">
                    <i class="fas fa-fw fa-undo"></i>
                    <span>Pengembalian</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Laporan -->
            <li class="nav-item">
                <a class="nav-link" href="laporan.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="confirmLogout()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
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
                        <li class="nav-item dropdown no-arrow">
                           
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Data Laporan</h1>
                    </div>

                    <!-- Search dan Filter -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <form action="" method="GET" class="d-flex">
                                        <div class="input-group mr-2">
                                            <input type="text" class="form-control bg-light border-0 small" 
                                                   name="search" placeholder="Cari data..." 
                                                   value="<?= htmlspecialchars($search) ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <select name="status" class="form-control bg-light border-0 small" onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="Selesai" <?= $status_filter == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                            <option value="Tidak Selesai" <?= $status_filter == 'Tidak Selesai' ? 'selected' : '' ?>>Tidak Selesai</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Table -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID Sewa</th>
                                            <th>Customer</th>
                                            <th>Mobil</th>
                                            <th>Harga</th>
                                            <th>Denda</th>
                                            <th>Total</th>
                                            <th>Tgl Sewa</th>
                                            <th>Tgl Kembali</th>
                                            <th>Tgl Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['id_sewa']) ?></td>
                                                <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                                                <td><?= htmlspecialchars($row['merk']) ?> (<?= htmlspecialchars($row['no_plat']) ?>)</td>
                                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($row['harga'] + $row['denda'], 0, ',', '.') ?></td>
                                                <td><?= date('d/m/Y', strtotime($row['tlg_sewa'])) ?></td>
                                                <td><?= date('d/m/Y', strtotime($row['tgl_kembali'])) ?></td>
                                                <td><?= $row['tgl_pengembalian'] ? date('d/m/Y', strtotime($row['tgl_pengembalian'])) : '-' ?></td>
                                                <td>
                                                    <span class="badge <?= $row['status'] == 'Selesai' ? 'badge-success' : 'badge-warning' ?>">
                                                        <?= $row['status'] ?: 'Tidak Selesai' ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($row['status'] == 'Selesai'): ?>
                                                        <div class="btn-group">
                                                            <button onclick="hapusLaporan('<?= $row['id_sewa'] ?>')" 
                                                                    class="btn btn-danger btn-sm" 
                                                                    title="Hapus">
                                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                                            </button>
                                                            <a href="download.php?id_sewa=<?= $row['id_sewa'] ?>" 
                                                               class="btn btn-primary btn-sm" 
                                                               title="Cetak">
                                                                <i class="fas fa-download me-1"></i> Download
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <style>
    .badge {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .table {
        font-size: 14px;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fc;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .btn {
        padding: 8px 16px;
        margin: 0 2px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-group .btn i {
        margin-right: 5px;
    }

    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-danger:hover {
        background-color: #be3c30;
        border-color: #be3c30;
    }

    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2e59d9;
    }

    /* Search box styling */
    .form-control {
        height: 45px;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 4px 0 0 4px;
        background-color: #f8f9fc !important;
    }

    .input-group-append .btn {
        padding: 10px 20px;
        border-radius: 0 4px 4px 0;
    }

    select.form-control {
        border-radius: 4px;
    }

    /* Tambahan style untuk form filter */
    .d-flex {
        display: flex !important;
        gap: 10px;
    }

    .input-group {
        width: 300px;
    }

    select.form-control {
        width: 150px;
    }

    @media (max-width: 768px) {
        .d-flex {
            flex-direction: column;
        }
        
        .input-group,
        select.form-control {
            width: 100%;
            margin-bottom: 10px;
        }
    }
    </style>

    <script>
    function hapusLaporan(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapus_laporan.php?id_sewa=' + id;
            }
        });
    }

    // Tampilkan SweetAlert jika ada pesan sukses/error dari halaman lain
    <?php if(isset($_SESSION['success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $_SESSION['success'] ?>',
            timer: 3000,
            showConfirmButton: false
        });
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?= $_SESSION['error'] ?>',
            timer: 3000,
            showConfirmButton: false
        });
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    function confirmLogout() {
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Logout Berhasil!',
                    text: 'Anda akan dialihkan ke halaman login',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'login.php';
                });
            }
        });
        return false;
    }
    </script>

</body>

</html>