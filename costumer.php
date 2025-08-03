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
    <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

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
                                            <button class="btn btn-primary" type="button" href="caricos.php">
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

                    <!-- Page header -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 text-gray-800">Kelola Data Customer</h1>
                        <div class="d-flex gap-2">
                            <a href="form_costumer.php" class="btn btn-primary">
                                <i class="fas fa-plus fa-sm mr-2"></i>Tambah Customer
                            </a>
                        </div>
                    </div>

                    <!-- Search box -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control search-input" 
                                       placeholder="Cari berdasarkan nama, ID, atau no telepon...">
                                <div class="input-group-append">
                                    <button class="btn search-btn" type="button">
                                        <i class="fas fa-search fa-sm text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID Customer</th>
                                    <th>Nama Customer</th>
                                    <th>Gender</th>
                                    <th>No Telpon</th>
                                    <th>Alamat</th>
                                    <th>Foto Identitas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'koneksi.php';

                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                
                                $sql = "SELECT * FROM customer";
                                if ($search) {
                                    $search = $conn->real_escape_string($search);
                                    $sql .= " WHERE 
                                        nama_customer LIKE '%$search%' OR 
                                        id_customer LIKE '%$search%' OR 
                                        no_telpon LIKE '%$search%' OR
                                        alamat LIKE '%$search%'";
                                }
                                
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row["id_customer"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["nama_customer"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["no_telpon"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";
                                        if (!empty($row['foto_identitas'])) {
                                            echo '<td><img src="uploads/' . htmlspecialchars($row['foto_identitas']) . '" alt="Foto Identitas" class="foto-thumb" style="max-height:60px;max-width:80px;border-radius:6px;border:1px solid #ccc;cursor:pointer" onclick="showFullImage(\'uploads/' . htmlspecialchars($row['foto_identitas']) . '\')"></td>';
                                        } else {
                                            echo '<td>-</td>';
                                        }
                                        echo "<td class='action-buttons'>";
                                        echo "<button class='btn btn-warning btn-sm' onclick='editCustomer(" . $row["id_customer"] . ")'>
                                                <i class='fas fa-edit mr-1'></i>Edit
                                              </button> ";
                                        echo "<button class='btn btn-danger btn-sm' onclick='deleteCustomer(" . $row["id_customer"] . ")'>
                                                <i class='fas fa-trash mr-1'></i>Hapus
                                              </button>";
                                        echo "</td>";
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

    <script>
    function editCustomer(id) {
        window.location.href = 'form_ubahcos.php?id_customer=' + id;
    }

    function deleteCustomer(id) {
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
                window.location.href = 'hapuscos.php?id_customer=' + id;
            }
        });
    }
    </script>

    <style>
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .action-buttons .btn {
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%) !important;
        border: none !important;
        color: white !important;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
        border: none !important;
    }

    /* Styling untuk SweetAlert */
    .swal2-popup {
        border-radius: 15px;
    }

    .swal2-confirm {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%) !important;
        border-radius: 6px !important;
        padding: 0.6rem 2rem !important;
    }

    .swal2-cancel {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%) !important;
        border-radius: 6px !important;
        padding: 0.6rem 2rem !important;
    }

    .search-input {
        height: 50px;
        border: 1px solid #e3e6f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        padding: 0 20px;
        font-size: 14px;
        color: #6e707e;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .search-input:focus {
        border-color: #4e73df;
        box-shadow: none;
        outline: none;
    }

    .search-input::placeholder {
        color: #858796;
        opacity: 0.8;
    }

    .search-btn {
        width: 50px;
        background: #3498db;
        border: none;
        border-radius: 0 10px 10px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #2c3e50;
    }

    .input-group {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    </style>

    <script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>

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

    <!-- Modal untuk preview gambar -->
    <div class="modal fade" id="modalFotoIdentitas" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalFotoLabel">Foto Identitas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <img id="fullFotoIdentitas" src="" alt="Foto Identitas" style="max-width:100%;max-height:70vh;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,0.2);">
          </div>
        </div>
      </div>
    </div>

    <script>
    function showFullImage(src) {
        document.getElementById('fullFotoIdentitas').src = src;
        $('#modalFotoIdentitas').modal('show');
    }
    </script>

</body>

</html>