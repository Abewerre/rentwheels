<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

// Koneksi PDO
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

// Fungsi untuk generate ID Sewa yang unik
function generateIdSewa() {
    include 'koneksi.php';
    
    // Format: SW + YYMMDD + INCREMENT
    $today = date('ymd');
    $prefix = "SW" . $today;
    
    // Cek ID terakhir dengan prefix hari ini
    $sql = "SELECT MAX(SUBSTRING(id_sewa, -3)) as last_increment 
            FROM sewa 
            WHERE id_sewa LIKE '$prefix%'";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    $lastIncrement = $row['last_increment'] ?? '000';
    $nextIncrement = str_pad((int)$lastIncrement + 1, 3, '0', STR_PAD_LEFT);
    
    return $prefix . $nextIncrement;
}

// Gunakan fungsi ini untuk mengisi value ID Sewa
$newIdSewa = generateIdSewa();

// Query untuk data mobil
$query_mobil = "SELECT * FROM mobil WHERE status = 'Tersedia'";
$stmt_mobil = $pdo->query($query_mobil);
$mobils = $stmt_mobil->fetchAll(PDO::FETCH_ASSOC);

// Query untuk customer
$query_customer = "SELECT c.* 
                  FROM customer c 
                  WHERE NOT EXISTS (
                      SELECT 1 
                      FROM sewa s 
                      WHERE s.id_customer = c.id_customer 
                      AND s.tgl_pengembalian IS NULL
                  )";
$stmt_customer = $pdo->query($query_customer);
$customers = $stmt_customer->fetchAll(PDO::FETCH_ASSOC);

// Tambahkan fungsi untuk cek status customer
function checkCustomerStatus($pdo, $id_customer) {
    $sql = "SELECT COUNT(*) FROM sewa WHERE id_customer = ? AND tgl_pengembalian IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_customer]);
    return $stmt->fetchColumn() > 0;
}

// Endpoint untuk cek status customer via AJAX
if(isset($_POST['check_customer'])) {
    header('Content-Type: application/json');
    $id_customer = $_POST['id_customer'];
    echo json_encode(['is_renting' => checkCustomerStatus($pdo, $id_customer)]);
    exit;
}

// Proses penyimpanan data ke tabel sewa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['check_customer'])) {
    header('Content-Type: application/json');
    try {
        $pdo->beginTransaction();

        $id_sewa = $_POST['id_sewa'];
        $id_mobil = $_POST['id_mobil'];
        $id_customer = $_POST['id_customer'];
        $tanggal_sewa = $_POST['tanggal_sewa'];
        $jam_sewa = $_POST['jam_sewa'];
        $tanggal_kembali = $_POST['tanggal_kembali'];
        $jam_kembali = $_POST['jam_kembali'];
        $harga = $_POST['harga'];

        // Cek apakah customer sedang menyewa
        if(checkCustomerStatus($pdo, $id_customer)) {
            $pdo->rollBack();
            echo json_encode([
                'status' => 'error', 
                'message' => 'Customer ini masih memiliki mobil yang belum dikembalikan!'
            ]);
            exit;
        }

        // Cek apakah id_mobil sudah ada di tabel sewa
        $sqlCheckMobil = 'SELECT COUNT(*) FROM sewa WHERE id_mobil = ? AND tgl_pengembalian IS NULL';
        $stmtCheckMobil = $pdo->prepare($sqlCheckMobil);
        $stmtCheckMobil->execute([$id_mobil]);
        $count = $stmtCheckMobil->fetchColumn();

        if ($count > 0) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Mobil sedang dipakai!']);
            exit;
        }

        // Insert ke tabel sewa
        $sqlSewa = 'INSERT INTO sewa (id_sewa, id_mobil, id_customer, tlg_sewa, jam_sewa, tgl_kembali, jam_kembali, harga, denda, bayar, uang_kembali, tgl_pengembalian) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, NULL)';
        $stmtSewa = $pdo->prepare($sqlSewa);
        $stmtSewa->execute([$id_sewa, $id_mobil, $id_customer, $tanggal_sewa, $jam_sewa, $tanggal_kembali, $jam_kembali, $harga]);

        // Update status mobil
        $sqlUpdateMobil = "UPDATE mobil SET status = 'Disewa' WHERE id_mobil = ?";
        $stmtUpdateMobil = $pdo->prepare($sqlUpdateMobil);
        $stmtUpdateMobil->execute([$id_mobil]);

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan!']);
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        exit;
    }
}

// HTML dan tampilan tetap sama seperti sebelumnya...
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form Sewa - Rent Wheels</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/form_mobil.css" rel="stylesheet">
    <link href="css/sidebar-style.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
    /* Pastikan pop-up Flatpickr selalu di atas */
    .flatpickr-calendar {
        z-index: 9999 !important;
    }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Sewa Mobil</h6>
                        </div>
                        <div class="card-body">
                            <form action="formsewa.php" method="POST" id="formSewa">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_sewa">ID Sewa</label>
                                            <input type="text" name="id_sewa" id="id_sewa" class="form-control mb-3" value="<?php echo $newIdSewa; ?>" readonly aria-label="ID Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" id="harga" class="form-control mb-3" readonly aria-label="Harga">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_mobil">Mobil</label>
                                            <select name="id_mobil" id="id_mobil" class="form-control mb-3" required aria-label="Pilih Mobil" onchange="updateMobilDetails()">
                                                <option value="">Pilih Mobil</option>
                                                <?php foreach($mobils as $mobil): ?>
                                                    <option value="<?= $mobil['id_mobil'] ?>"><?= $mobil['merk'] ?> - <?= $mobil['no_plat'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="search_customer">Customer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" id="search_customer" class="form-control" placeholder="Cari nama customer..." autocomplete="off" aria-label="Cari nama customer">
                                                <input type="hidden" name="id_customer" id="id_customer" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" onclick="showCustomerModal()" aria-label="Cari Customer">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small id="selected_customer" class="form-text text-muted"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_sewa">Tanggal Sewa</label>
                                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control mb-3" required aria-label="Tanggal Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_sewa">Jam Sewa</label>
                                            <input type="text" name="jam_sewa" id="jam_sewa" class="form-control mb-3" required aria-label="Jam Sewa" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_kembali">Tanggal Kembali</label>
                                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control mb-3" required aria-label="Tanggal Kembali">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_kembali">Jam Kembali</label>
                                            <input type="text" name="jam_kembali" id="jam_kembali" class="form-control mb-3" required aria-label="Jam Kembali" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                                        <a href="sewa.php" class="btn btn-secondary">Kembali</a>
                                    </div>
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
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk cek status customer
        function checkCustomerStatus(id_customer) {
            return fetch('formsewa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'check_customer=1&id_customer=' + id_customer
            })
            .then(response => response.json())
            .then(data => {
                if(data.is_renting) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Dapat Memilih Customer',
                        text: 'Customer ini masih memiliki mobil yang belum dikembalikan!',
                        confirmButtonColor: '#4e73df'
                    });
                    document.getElementById('id_customer').value = '';
                    document.getElementById('search_customer').value = '';
                    document.getElementById('selected_customer').textContent = '';
                    return false;
                }
                return true;
            });
        }

        // Modifikasi fungsi selectCustomer
        window.selectCustomer = async function(id, nama) {
            const canRent = await checkCustomerStatus(id);
            if(canRent) {
                document.getElementById('id_customer').value = id;
                document.getElementById('search_customer').value = nama;
                document.getElementById('selected_customer').textContent = 'ID Customer: ' + id;
                $('#customerModal').modal('hide');
            }
        }

        // Modifikasi event listener form submit
        document.getElementById('formSewa').addEventListener('submit', async function(e) {
            e.preventDefault();
            // Validasi form
            let id_mobil = document.getElementById('id_mobil').value;
            let id_customer = document.getElementById('id_customer').value;
            let harga = document.getElementById('harga').value;
            let tanggal_sewa = document.getElementById('tanggal_sewa').value;
            let tanggal_kembali = document.getElementById('tanggal_kembali').value;
            if (!id_mobil || !id_customer || !harga || !tanggal_sewa || !tanggal_kembali) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Semua field harus diisi!'
                });
                return;
            }
            // Cek status customer sebelum submit
            const canRent = await checkCustomerStatus(id_customer);
            if(!canRent) {
                return;
            }
            // Kirim data menggunakan fetch
            fetch('formsewa.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'sewa.php';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            });
        });

        window.updateMobilDetails = function() {
            var id_mobil = document.getElementById('id_mobil').value;
            var mobils = <?php echo json_encode($mobils); ?>;
            var selectedMobil = mobils.find(mobil => mobil.id_mobil == id_mobil);
            if (selectedMobil) {
                document.getElementById('harga').value = selectedMobil.harga;
            }
        }

        window.showCustomerModal = function() {
            $('#customerModal').modal('show');
        }

        // Pencarian di modal
        var customerSearch = document.getElementById('customerSearch');
        if (customerSearch) {
            customerSearch.addEventListener('keyup', function() {
                let search = this.value.toLowerCase();
                let rows = document.getElementById('customerTableBody').getElementsByTagName('tr');
                for (let row of rows) {
                    let nama = row.getElementsByTagName('td')[1].textContent.toLowerCase();
                    let noTelp = row.getElementsByTagName('td')[2].textContent.toLowerCase();
                    if (nama.includes(search) || noTelp.includes(search)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // Flatpickr
        if (typeof flatpickr === 'undefined') {
            alert('Flatpickr gagal dimuat! Pastikan koneksi internet dan CDN Flatpickr aktif.');
            return;
        }
        var jamSewa = document.getElementById('jam_sewa');
        var jamKembali = document.getElementById('jam_kembali');
        if (!jamSewa) {
            alert('Input jam_sewa tidak ditemukan di DOM!');
            return;
        }
        if (!jamKembali) {
            alert('Input jam_kembali tidak ditemukan di DOM!');
            return;
        }
        console.log('Flatpickr akan diinisialisasi pada jam_sewa dan jam_kembali');
        flatpickr("#jam_sewa", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            clickOpens: true,
            allowInput: false
        });
        flatpickr("#jam_kembali", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            clickOpens: true,
            allowInput: false
        });
    });
    </script>

    <!-- Tambahkan modal untuk pencarian customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Customer</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="customerSearch" class="form-control mb-3" placeholder="Cari customer...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>No. Telpon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                            <?php if(empty($customers)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada customer yang tersedia untuk menyewa</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($customers as $customer): ?>
                                <tr>
                                    <td><?= $customer['id_customer'] ?></td>
                                    <td><?= $customer['nama_customer'] ?></td>
                                    <td><?= $customer['no_telpon'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" 
                                                onclick="selectCustomer('<?= $customer['id_customer'] ?>', '<?= $customer['nama_customer'] ?>')">
                                            Pilih
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

