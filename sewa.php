<?php
// Pastikan ini ada di paling atas file setelah include koneksi
include 'koneksi.php';

// Definisi variabel search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk data sewa dengan JOIN ke tabel customer
$sql = "SELECT s.*, c.nama_customer 
        FROM sewa s 
        LEFT JOIN customer c ON s.id_customer = c.id_customer";

// Tambahkan kondisi pencarian jika ada
if(!empty($search)) {
    $sql .= " WHERE s.id_sewa LIKE '%$search%' 
              OR c.nama_customer LIKE '%$search%' 
              OR s.id_mobil LIKE '%$search%'
              OR s.harga LIKE '%$search%'";
}

$sql .= " ORDER BY s.id_sewa DESC";
$result = $conn->query($sql);

// Pastikan semua kode PHP ada di atas konten HTML
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rent Wheels - Kelola Sewa</title>

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

                </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Sewa Mobil</h1>
                        <a href="formsewa.php" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Tambah Sewa</span>
                                    </a>
                    </div>

                    <!-- Data Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row align-items-center">
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <form method="GET" class="form-inline">
                                        <div class="input-group w-100">
                                            <input type="text" class="form-control bg-light border-0 small" 
                                                   name="search" placeholder="Cari data..." 
                                                   value="<?php echo $search; ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID Sewa</th>
                                            <th>Nama Customer</th>
                                            <th>ID Mobil</th>
                                            <th>Harga</th>
                                            <th>Tanggal Sewa</th>
                                            <th>Jam Sewa</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Jam Kembali</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><span class='font-weight-bold'>" . $row["id_sewa"] . "</span></td>";
                                                echo "<td>" . $row["nama_customer"] . "</td>";
                                                echo "<td>" . $row["id_mobil"] . "</td>";
                                                echo "<td><span class='text-primary'>Rp " . number_format($row["harga"], 0, ',', '.') . "</span></td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row["tlg_sewa"])) . "</td>";
                                                echo "<td>" . ($row["jam_sewa"] ? date('H:i', strtotime($row["jam_sewa"])) : '-') . "</td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row["tgl_kembali"])) . "</td>";
                                                echo "<td>" . ($row["jam_kembali"] ? date('H:i', strtotime($row["jam_kembali"])) : '-') . "</td>";
                                                echo "<td class='text-center'>
                                                        <div class='d-flex justify-content-center flex-wrap gap-2'>
                                                            <button onclick='editSewa(\"" . $row["id_sewa"] . "\")' 
                                                                    class='btn btn-warning btn-sm d-flex align-items-center' aria-label='Edit Sewa'>
                                                                <i class='fas fa-edit fa-fw mr-1'></i> Edit
                                                            </button>
                                                            <button onclick='deleteSewa(\"" . $row["id_sewa"] . "\")' 
                                                                    class='btn btn-danger btn-sm d-flex align-items-center' aria-label='Hapus Sewa'>
                                                                <i class='fas fa-trash fa-fw mr-1'></i> Hapus
                                                            </button>
                                                        </div>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function deleteSewa(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data sewa ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapussewa.php?id_sewa=' + id;
            }
        });
    }

    function editSewa(id) {
        window.location.href = 'ubahsewa.php?id_sewa=' + id;
    }

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

    <style>
    .btn-icon-split {
        padding: 0.375rem 0.75rem;
    }

    .btn-icon-split .icon {
        padding: 0.375rem 0.75rem;
        margin-right: 0.5rem;
        border-right: 1px solid rgba(255,255,255,0.15);
    }

    .table td, .table th {
        vertical-align: middle;
        padding: 0.75rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .input-group .form-control {
        height: calc(1.5em + 0.75rem + 2px);
    }

    .card-header {
        padding: 1rem 1.25rem;
    }

    @media (max-width: 768px) {
        .text-md-right {
            text-align: left !important;
        }
        
        .mb-md-0 {
            margin-bottom: 1rem !important;
        }
    }

    .gap-2 > * {
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .gap-2 > *:last-child {
        margin-right: 0;
    }
    </style>

</body>

</html>