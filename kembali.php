<?php
include 'koneksi.php';

// Query untuk menampilkan semua data sewa
$sql = "SELECT s.*, 
        c.nama_customer, 
        m.merk, 
        m.no_plat 
        FROM sewa s 
        LEFT JOIN customer c ON s.id_customer = c.id_customer 
        LEFT JOIN mobil m ON s.id_mobil = m.id_mobil 
        ORDER BY 
            CASE 
                WHEN s.status = 'Tidak Selesai' OR s.status IS NULL THEN 1
                ELSE 2
            END,
            s.tlg_sewa DESC";
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

    <title>Rent Wheels - Pengembalian</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <link href="css/form_mobil.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
    <!-- Tambahkan CSS sidebar -->
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
            <li class="nav-item active">
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
                       

                        <!-- Nav Item - User Information -->


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading & Search/Filter -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Kelola Data Pengembalian</h1>
                        <div class="d-flex">
                            <!-- Filter Status -->
                            <select id="statusFilter" class="custom-select mr-3" style="width: 150px;">
                                <option value="">Semua Status</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Tidak Selesai">Tidak Selesai</option>
                            </select>
                            <!-- Search Box -->
                            <div class="input-group" style="width: 300px;">
                                <input type="text" id="searchInput" class="form-control bg-light border-0 small" 
                                       placeholder="Cari data..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Setelah Page Heading, tambahkan bagian search dan filter -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID Sewa</th>
                                            <th>Customer</th>
                                            <th>Mobil</th>
                                            <th>Harga</th>
                                            <th>Denda</th>
                                            <th>Total Bayar</th>
                                            <th>Tgl Sewa</th>
                                            <th>Jam Sewa</th>
                                            <th>Tgl Kembali</th>
                                            <th>Jam Kembali</th>
                                            <th>Tgl Pengembalian</th>
                                            <th>Jam Pengembalian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while($row = $result->fetch_assoc()): 
                                        $total_harga = $row['harga'] + $row['denda'];
                                        $status_class = $row['status'] == 'Selesai' ? 'badge badge-success' : 'badge badge-warning';
                                    ?>
                                        <tr>
                                            <td><?= $row['id_sewa'] ?></td>
                                            <td><?= $row['nama_customer'] ?></td>
                                            <td><?= $row['merk'] ?> - <?= $row['no_plat'] ?></td>
                                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($row['denda'], 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($total_harga, 0, ',', '.') ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['tlg_sewa'])) ?></td>
                                            <td><?= $row['jam_sewa'] ? date('H:i', strtotime($row['jam_sewa'])) : '-' ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['tgl_kembali'])) ?></td>
                                            <td><?= $row['jam_kembali'] ? date('H:i', strtotime($row['jam_kembali'])) : '-' ?></td>
                                            <td><?= $row['tgl_pengembalian'] ? date('d/m/Y', strtotime($row['tgl_pengembalian'])) : '-' ?></td>
                                            <td><?= isset($row['jam_pengembalian']) && $row['jam_pengembalian'] ? date('H:i', strtotime($row['jam_pengembalian'])) : '-' ?></td>
                                            <td><span class="<?= $status_class ?>"><?= $row['status'] ?: 'Tidak Selesai' ?></span></td>
                                            <td class="text-center">
                                                <?php if($row['status'] != 'Selesai'): ?>
                                                    <!-- Tampilkan tombol Kembali dan Hapus untuk status Tidak Selesai -->
                                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                                        <a href="ubahkembali.php?id_sewa=<?= $row['id_sewa'] ?>" 
                                                           class="btn btn-success btn-sm d-flex align-items-center action-btn mb-1" aria-label="Proses Pengembalian">
                                                            <i class="fas fa-undo me-2 mr-1"></i>
                                                            <span>Kembali</span>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm d-flex align-items-center action-btn" 
                                                                onclick="hapusSewa('<?= $row['id_sewa'] ?>')" aria-label="Hapus Sewa">
                                                            <i class="fas fa-trash-alt me-2 mr-1"></i>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- Tampilkan tombol Hapus untuk status Selesai -->
                                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                                        <button class="btn btn-danger btn-sm d-flex align-items-center action-btn" 
                                                                onclick="hapusSewa('<?= $row['id_sewa'] ?>')" aria-label="Hapus Sewa">
                                                            <i class="fas fa-trash-alt me-2 mr-1"></i>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        
                      

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

    <!-- Tambahkan Script untuk Search dan Filter -->
    <script>
    $(document).ready(function() {
        // Search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Status filter
        $("#statusFilter").on("change", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                if (value === "") {
                    $(this).show();
                } else {
                    // Kolom status ada di kolom ke-13 (td:nth-child(13))
                    var status = $(this).find("td:nth-child(13)").text().toLowerCase();
                    $(this).toggle(status === value);
                }
            });
        });
    });

    // Fungsi hapus dengan SweetAlert
    function hapusSewa(id) {
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
                window.location.href = 'hapussewa.php?id_sewa=' + id;
            }
        });
    }
    </script>

    <!-- Tambahkan Style -->
    <style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .card-header {
        background: linear-gradient(to right, #4e73df, #224abe);
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .table thead th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 30px;
        font-weight: 500;
    }

    .btn-sm {
        border-radius: 5px;
        margin: 0 2px;
    }

    .custom-select {
        border-radius: 5px;
        border: 1px solid #d1d3e2;
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group-append .btn {
        border-left: none;
    }

    /* Sidebar Styles */
    .sidebar {
        background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .sidebar-brand {
        height: 70px;
        padding: 1rem;
    }

    .sidebar-heading {
        color: rgba(255,255,255,0.6);
        font-size: 0.8rem;
        padding: 0 1rem;
        margin-bottom: 0.5rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .nav-item.active .nav-link {
        background: rgba(255,255,255,0.1);
        border-radius: 5px;
        margin: 0 1rem;
    }

    .nav-item .nav-link {
        padding: 0.8rem 1rem;
        margin: 0 1rem;
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }

    .nav-item .nav-link:hover {
        background: rgba(255,255,255,0.1);
        border-radius: 5px;
    }

    .nav-item .nav-link i {
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    /* Search & Filter Styles */
    .custom-select {
        height: calc(1.5em + 0.75rem + 6px);
        border-radius: 10rem;
        font-size: 0.85rem;
        border: 1px solid #d1d3e2;
    }

    .input-group .form-control {
        border-radius: 10rem 0 0 10rem;
        font-size: 0.85rem;
    }

    .input-group-append .btn {
        border-radius: 0 10rem 10rem 0;
        padding: 0.375rem 0.75rem;
    }

    .input-group .form-control:focus {
        box-shadow: none;
        border-color: #4e73df;
    }

    .sidebar-divider {
        border-top: 1px solid rgba(255,255,255,0.15);
        margin: 1rem 0;
    }

    .action-btn {
        width: 120px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: all 0.3s ease;
        font-size: 13px;
        font-weight: 500;
    }

    .action-btn i {
        margin-right: 8px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-danger:hover {
        background-color: #dc3545;
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
    }

    .btn-success:hover {
        background-color: #28a745;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }

    @media (max-width: 768px) {
        .action-btn {
            width: 100px;
            font-size: 12px;
            padding: 6px 10px;
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

    <script>
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