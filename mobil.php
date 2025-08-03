<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rent Wheels - Kelola Mobil</title>

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

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 text-gray-800">Kelola Data Mobil</h1>
                        <a href="form_mobil.php" class="btn btn-primary">
                            <i class="fas fa-plus fa-sm mr-2"></i>Tambah Mobil
                        </a>
                    </div>

                    <!-- Search dan Filter -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="" method="GET" class="input-group">
                                <input type="text" class="form-control search-input" name="search" 
                                       placeholder="Cari mobil..." 
                                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <div class="input-group-append">
                                    <button class="btn search-btn h-100" type="submit">
                                        <i class="fas fa-search fa-sm text-white"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="GET" class="d-flex justify-content-end">
                                <select name="status" class="form-control select-status" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="tersedia" <?php echo (isset($_GET['status']) && $_GET['status'] == 'tersedia') ? 'selected' : ''; ?>>tersedia</option>
                                    <option value="disewa" <?php echo (isset($_GET['status']) && $_GET['status'] == 'disewa') ? 'selected' : ''; ?>>disewa</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Cars Table -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID Mobil</th>
                                            <th>Merk</th>
                                            <th>Gambar</th>
                                            <th>No Plat</th>
                                            <th>Warna</th>
                                            <th>Tahun</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include 'koneksi.php';

                                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                                        $status = isset($_GET['status']) ? $_GET['status'] : '';
                                        
                                        $sql = "SELECT * FROM mobil WHERE 1=1";
                                        if ($search) {
                                            $search = $conn->real_escape_string($search);
                                            $sql .= " AND (merk LIKE '%$search%' OR 
                                                      no_plat LIKE '%$search%' OR 
                                                      warna LIKE '%$search%')";
                                        }
                                        
                                        if ($status) {
                                            $status = $conn->real_escape_string($status);
                                            $sql .= " AND status = '$status'";
                                        }
                                        
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row["id_mobil"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["merk"]) . "</td>";
                                                echo "<td><img src='img/mobil/" . $row["gambar"] . "' 
                                                         alt='" . htmlspecialchars($row["merk"]) . "' 
                                                         class='img-fluid car-image' 
                                                         onclick='showFullImage(\"" . $row["gambar"] . "\", \"" . htmlspecialchars($row["merk"]) . "\")' 
                                                         style='cursor: pointer;'></td>";
                                                echo "<td>" . htmlspecialchars($row["no_plat"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["warna"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["tahun"]) . "</td>";
                                                echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                                                echo "<td><span class='badge badge-" . 
                                                    (strtolower($row["status"]) == 'tersedia' ? 'success' : 'danger') . "'>" 
                                                    . strtolower($row["status"]) . "</span></td>";
                                                echo "<td class='text-center'>
                                                        <div class='btn-group'>
                                                            <button class='btn btn-warning btn-sm' onclick='editMobil(" . $row["id_mobil"] . ")'>
                                                                <i class='fas fa-edit mr-1'></i>Edit
                                                            </button>
                                                            <button class='btn btn-danger btn-sm' onclick='deleteMobil(" . $row["id_mobil"] . ")'>
                                                                <i class='fas fa-trash mr-1'></i>Hapus
                                                            </button>
                                                        </div>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan</td></tr>";
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

    <script>
    function deleteMobil(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapus_mobil.php?id=' + id;
            }
        });
    }

    function editMobil(id) {
        window.location.href = 'tes2.php?id_mobil=' + id;
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

    function showFullImage(imageName, merk) {
        Swal.fire({
            title: merk,
            imageUrl: 'img/mobil/' + imageName,
            imageWidth: '100%',
            imageHeight: 'auto',
            imageAlt: merk,
            showCloseButton: true,
            showConfirmButton: false,
            width: '80%',
            padding: '20px',
            background: '#fff',
            customClass: {
                image: 'full-image-preview'
            }
        });
    }
    </script>

    <style>
    .search-input {
        height: 45px;
        border: 1px solid #e3e6f0;
        border-radius: 8px 0 0 8px;
        padding: 0 20px;
        font-size: 14px;
        color: #6e707e;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .search-btn {
        background: #3498db;
        border: none;
        width: 50px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0 8px 8px 0;
    }

    .search-btn i {
        line-height: 1;
    }

    .input-group {
        height: 45px;
    }

    .input-group-append {
        height: 100%;
    }

    .select-status {
        width: 200px;
        height: 45px;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        padding: 0 15px;
        font-size: 14px;
        color: #6e707e;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .select-status:focus {
        border-color: #4e73df;
        box-shadow: none;
        outline: none;
    }

    .btn-secondary {
        background: #858796;
        border: none;
        padding: 10px 20px;
        margin-left: 5px;
    }

    .btn-secondary:hover {
        background: #6e707e;
    }

    @media (max-width: 768px) {
        .col-md-6:last-child {
            margin-top: 1rem;
        }
        
        .select-status {
            width: 100%;
        }
    }

    .table img {
        width: 150px;  /* Lebar tetap */
        height: 100px; /* Tinggi tetap */
        object-fit: cover; /* Menjaga aspek rasio gambar */
        border-radius: 8px; /* Membuat sudut gambar sedikit melengkung */
        border: 1px solid #e3e6f0; /* Menambah border tipis */
        box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Efek bayangan halus */
    }

    .table td {
        vertical-align: middle; /* Membuat konten cell berada di tengah vertikal */
    }

    /* Tambahkan hover effect pada gambar */
    .table img:hover {
        transform: scale(1.05); /* Sedikit membesar saat hover */
        transition: transform 0.2s ease; /* Animasi smooth */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Bayangan lebih tegas saat hover */
    }

    .badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 4px;
    }

    .badge-success {
        background-color: #1cc88a; /* Hijau untuk status tersedia */
        color: white;
    }

    .badge-danger {
        background-color: #e74a3b; /* Merah untuk status tidak tersedia/disewa */
        color: white;
    }

    .btn-group {
        display: inline-flex;
        gap: 5px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    .text-center {
        text-align: center !important;
    }

    .car-image {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e3e6f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .car-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    .full-image-preview {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Sweet Alert custom styles */
    .swal2-popup {
        border-radius: 15px;
    }

    .swal2-title {
        color: #333;
        font-size: 1.5em;
        padding: 15px;
    }

    .swal2-image {
        margin: 0;
        border-radius: 8px;
    }
    </style>

</body>

</html>