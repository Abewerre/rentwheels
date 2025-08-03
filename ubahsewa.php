<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sewa = $_POST['id_sewa'];
    $id_mobil = $_POST['id_mobil'];
    $id_customer = $_POST['id_customer'];
    $harga = $_POST['harga'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $jam_sewa = $_POST['jam_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $jam_kembali = $_POST['jam_kembali'];
    
    // Mulai transaction
    $conn->begin_transaction();
    
    try {
        // Update data sewa
        $sql = "UPDATE sewa SET 
                id_mobil = ?, 
                id_customer = ?, 
                harga = ?, 
                tlg_sewa = ?, 
                jam_sewa = ?,
                tgl_kembali = ?, 
                jam_kembali = ?
                WHERE id_sewa = ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", 
            $id_mobil, 
            $id_customer, 
            $harga, 
            $tanggal_sewa, 
            $jam_sewa,
            $tanggal_kembali, 
            $jam_kembali,
            $id_sewa
        );
        
        if ($stmt->execute()) {
            $conn->commit();
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui'
            ]);
        } else {
            throw new Exception("Gagal mengupdate data");
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}

// Ambil data sewa yang akan diubah
if (isset($_GET['id_sewa'])) {
    $id_sewa = $_GET['id_sewa'];
    
    // Query untuk mendapatkan data sewa
    $sql = "SELECT * FROM sewa WHERE id_sewa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_sewa);
    $stmt->execute();
    $result = $stmt->get_result();
    $sewa = $result->fetch_assoc();
    
    if (!$sewa) {
        echo "Data sewa tidak ditemukan";
        exit;
    }
    
    // Query untuk mendapatkan data mobil
    $sql_mobil = "SELECT * FROM mobil";
    $result_mobil = $conn->query($sql_mobil);
    $mobils = [];
    while ($row = $result_mobil->fetch_assoc()) {
        $mobils[] = $row;
    }
    
    // Query untuk mendapatkan data customer
    $sql_customer = "SELECT * FROM customer";
    $result_customer = $conn->query($sql_customer);
    $customers = [];
    while ($row = $result_customer->fetch_assoc()) {
        $customers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Sewa - Rent Wheels</title>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data Sewa</h6>
                        </div>
                        <div class="card-body">
                            <form id="formEditSewa">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_sewa">ID Sewa</label>
                                            <input type="text" name="id_sewa" class="form-control mb-3" value="<?php echo $sewa['id_sewa']; ?>" readonly aria-label="ID Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" id="harga" class="form-control mb-3" value="<?php echo $sewa['harga']; ?>" readonly aria-label="Harga">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_mobil">Mobil</label>
                                            <select name="id_mobil" id="id_mobil" class="form-control mb-3" required aria-label="Pilih Mobil" onchange="updateMobilDetails()">
                                                <?php foreach ($mobils as $mobil) : ?>
                                                    <option value="<?php echo $mobil['id_mobil']; ?>" <?php echo ($mobil['id_mobil'] == $sewa['id_mobil']) ? 'selected' : ''; ?>>
                                                        <?php echo $mobil['merk']; ?> - <?php echo $mobil['no_plat']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_customer">Customer</label>
                                            <select name="id_customer" id="id_customer" class="form-control mb-3" required aria-label="Pilih Customer">
                                                <?php foreach ($customers as $customer) : ?>
                                                    <option value="<?php echo $customer['id_customer']; ?>" <?php echo ($customer['id_customer'] == $sewa['id_customer']) ? 'selected' : ''; ?>>
                                                        <?php echo $customer['nama_customer']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_sewa">Tanggal Sewa</label>
                                            <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control mb-3" value="<?php echo $sewa['tlg_sewa']; ?>" required aria-label="Tanggal Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_sewa">Jam Sewa</label>
                                            <input type="text" name="jam_sewa" id="jam_sewa" class="form-control mb-3" value="<?php echo isset($sewa['jam_sewa']) ? $sewa['jam_sewa'] : ''; ?>" required aria-label="Jam Sewa" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_kembali">Tanggal Kembali</label>
                                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control mb-3" value="<?php echo $sewa['tgl_kembali']; ?>" required aria-label="Tanggal Kembali">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_kembali">Jam Kembali</label>
                                            <input type="text" name="jam_kembali" id="jam_kembali" class="form-control mb-3" value="<?php echo isset($sewa['jam_kembali']) ? $sewa['jam_kembali'] : ''; ?>" required aria-label="Jam Kembali" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-save fa-sm mr-2"></i>Simpan Perubahan
                                        </button>
                                        <a href="sewa.php" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left fa-sm mr-2"></i>Kembali
                                        </a>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    document.getElementById('formEditSewa').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validasi form
        let id_mobil = document.getElementById('id_mobil').value;
        let harga = document.getElementById('harga').value;
        let tanggal_sewa = document.querySelector('input[name="tanggal_sewa"]').value;
        let tanggal_kembali = document.querySelector('input[name="tanggal_kembali"]').value;
        
        if (!id_mobil || !harga || !tanggal_sewa || !tanggal_kembali) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Semua field harus diisi!',
                confirmButtonColor: '#4e73df'
            });
            return;
        }

        // Kirim data menggunakan fetch
        fetch('ubahsewa.php?id_sewa=<?php echo $id_sewa; ?>', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data sewa berhasil diperbarui',
                    confirmButtonColor: '#4e73df'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'sewa.php';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message,
                    confirmButtonColor: '#4e73df'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan saat memperbarui data',
                confirmButtonColor: '#4e73df'
            });
        });
    });

    function updateMobilDetails() {
        var id_mobil = document.getElementById('id_mobil').value;
        var mobils = <?php echo json_encode($mobils); ?>;
        var selectedMobil = mobils.find(mobil => mobil.id_mobil == id_mobil);
        if (selectedMobil) {
            document.getElementById('harga').value = selectedMobil.harga;
        }
    }

    flatpickr("#jam_sewa", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
    flatpickr("#jam_kembali", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
    </script>
</body>
</html>

