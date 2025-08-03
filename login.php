<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Rent Wheels</title>
    
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
                        
                        <!-- Right side - Login Form -->
                        <div class="col-lg-6">
                            <div class="login-content">
                                <div class="text-center mb-5">
                                    <h1 class="login-heading">Selamat Datang!</h1>
                                    <p class="text-muted">Silakan masuk ke akun Anda</p>
                                </div>
                                
                                <form class="user" action="login.php" method="POST">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="username" required placeholder="Masukkan Username">
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
                                            <input type="password" class="form-control" name="password" required placeholder="Masukkan password">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                                    </button>
                                </form>

                                <div class="login-footer">
                                    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
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
    session_start();
    include 'koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM petugas WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: 'Selamat datang kembali!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'costumer.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Username atau password salah',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        }
    }
    ?>
</body>

</html>