<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Rent Wheels</title>
    
    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/login-style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-10">
                <div class="card">
                    <div class="row no-gutters">
                        <!-- Left side - Image -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <div class="login-brand">
                                <i class="fas fa-car-side"></i>
                                <h2>Rent Wheels</h2>
                                <p>Your Journey, Our Priority</p>
                            </div>
                        </div>
                        
                        <!-- Right side - Register Form -->
                        <div class="col-lg-6">
                            <div class="login-content">
                                <div class="text-center mb-5">
                                    <h1 class="login-heading">Buat Akun</h1>
                                    <p class="text-muted">Silakan isi data diri Anda</p>
                                </div>
                                
                                <form class="user" action="register.php" method="POST">
                                    <div class="form-group">
                                        <label class="form-label">ID Petugas</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-id-card"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="id_petugas" 
                                                   required placeholder="Masukkan ID" pattern="\d+"
                                                   title="Hanya angka yang diperbolehkan">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Nama Petugas</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="nama_petugas" 
                                                   required placeholder="Masukkan Nama">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user-circle"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="username" 
                                                   required placeholder="Masukkan username">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control" name="password" 
                                                   required placeholder="Buat Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control" name="repeat_password" 
                                                   required placeholder="Ulangi Password">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-user-plus mr-2"></i>Daftar
                                    </button>
                                </form>

                                <div class="login-footer">
                                    <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
                                </div>
                            </div>
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

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'koneksi.php';
        
        $id_petugas = $_POST['id_petugas'];
        $nama_petugas = $_POST['nama_petugas'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];

        // Cek password match
        if ($password !== $repeat_password) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Password yang Anda masukkan tidak sama',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
            exit;
        }

        // Cek username exists
        $check_username = $conn->prepare("SELECT * FROM petugas WHERE username = ?");
        $check_username->bind_param("s", $username);
        $check_username->execute();
        if ($check_username->get_result()->num_rows > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Username Sudah Digunakan',
                    text: 'Silakan pilih username lain',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
            exit;
        }

        // Insert new user
        $sql = "INSERT INTO petugas (id_petugas, nama_petugas, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $id_petugas, $nama_petugas, $username, $password);

        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: 'Akun Anda telah dibuat',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
                    text: 'Terjadi kesalahan saat membuat akun',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        }
    }
    ?>
</body>

</html>