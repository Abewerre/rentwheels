<?php
include 'koneksi.php';

// Ambil data sewa berdasarkan ID
if(isset($_GET['id_sewa'])) {
    $id_sewa = $_GET['id_sewa'];
    $sql = "SELECT s.*, c.nama_customer, m.merk, m.no_plat 
            FROM sewa s
            JOIN customer c ON s.id_customer = c.id_customer
            JOIN mobil m ON s.id_mobil = m.id_mobil
            WHERE s.id_sewa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_sewa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form Pengembalian - Rent Wheels</title>

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
                            <h6 class="m-0 font-weight-bold text-primary">Form Pengembalian Mobil</h6>
                        </div>
                        <div class="card-body">
                            <form action="proses_kembali.php" method="POST" id="formPengembalian" onsubmit="return validateForm(event)">
                                <input type="hidden" name="id_sewa" value="<?= $row['id_sewa']; ?>">
                                <input type="hidden" name="harga_sewa" value="<?= $row['harga']; ?>">
                                <input type="hidden" name="tgl_kembali_asli" value="<?= $row['tgl_kembali']; ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_sewa">ID Sewa</label>
                                            <input type="text" class="form-control mb-3" value="<?= $row['id_sewa']; ?>" readonly aria-label="ID Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_customer">Nama Customer</label>
                                            <input type="text" class="form-control mb-3" value="<?= $row['nama_customer']; ?>" readonly aria-label="Nama Customer">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobil">Mobil</label>
                                            <input type="text" class="form-control mb-3" value="<?= $row['merk'] . ' (' . $row['no_plat'] . ')'; ?>" readonly aria-label="Mobil">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="harga_sewa">Harga Sewa</label>
                                            <input type="text" class="form-control mb-3" value="Rp <?= number_format($row['harga'], 0, ',', '.'); ?>" readonly aria-label="Harga Sewa">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_sewa">Tanggal Sewa</label>
                                            <input type="text" class="form-control mb-3" value="<?= date('d/m/Y', strtotime($row['tlg_sewa'])); ?>" readonly aria-label="Tanggal Sewa">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_sewa">Jam Sewa</label>
                                            <input type="text" class="form-control mb-3" value="<?= $row['jam_sewa'] ? date('H:i', strtotime($row['jam_sewa'])) : '-'; ?>" readonly aria-label="Jam Sewa">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_kembali">Tanggal Kembali</label>
                                            <input type="text" class="form-control mb-3" value="<?= date('d/m/Y', strtotime($row['tgl_kembali'])); ?>" readonly aria-label="Tanggal Kembali">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_kembali">Jam Kembali</label>
                                            <input type="text" class="form-control mb-3" value="<?= $row['jam_kembali'] ? date('H:i', strtotime($row['jam_kembali'])) : '-'; ?>" readonly aria-label="Jam Kembali">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_pengembalian">Tanggal Pengembalian <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control mb-3" name="tgl_pengembalian" id="tgl_pengembalian" required aria-label="Tanggal Pengembalian">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jam_pengembalian">Jam Pengembalian <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control mb-3" name="jam_pengembalian" id="jam_pengembalian" required readonly aria-label="Jam Pengembalian">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dendaDisplay">Denda/Potongan</label>
                                            <input type="text" class="form-control mb-3" id="dendaDisplay" readonly aria-label="Denda atau Potongan">
                                            <input type="hidden" name="denda" id="dendaHidden">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="totalBayarDisplay">Total Bayar</label>
                                            <input type="text" class="form-control mb-3" id="totalBayarDisplay" readonly aria-label="Total Bayar">
                                            <input type="hidden" name="bayar" id="totalBayarHidden">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-flex justify-content-start gap-2 flex-wrap">
                                        <button type="submit" class="btn btn-primary mr-2" aria-label="Proses Pengembalian">
                                            <i class="fas fa-save fa-sm mr-2"></i>Proses Pengembalian
                                        </button>
                                        <a href="kembali.php" class="btn btn-secondary" aria-label="Kembali ke Daftar Pengembalian">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <script>
    function validateForm(event) {
        event.preventDefault();
        
        const tglPengembalian = document.querySelector('input[name="tgl_pengembalian"]').value;
        if (!tglPengembalian) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tanggal pengembalian harus diisi!',
                confirmButtonColor: '#4e73df'
            });
            return false;
        }

        // Konfirmasi sebelum submit
        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: "Apakah data yang dimasukkan sudah benar?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form menggunakan AJAX
                const form = document.getElementById('formPengembalian');
                const formData = new FormData(form);

                fetch('proses_kembali.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Pengembalian berhasil diproses',
                        confirmButtonColor: '#4e73df'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open('download.php?id_sewa=' + document.querySelector('input[name="id_sewa"]').value, '_blank');
                            window.location.href = 'kembali.php';
                        }
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses pengembalian',
                        confirmButtonColor: '#4e73df'
                    });
                });
            }
        });

        return false;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tglPengembalianInput = document.querySelector('input[name="tgl_pengembalian"]');
        const hargaSewa = parseFloat(document.querySelector('input[name="harga_sewa"]').value);
        const tglKembaliAsli = new Date(document.querySelector('input[name="tgl_kembali_asli"]').value);
        const dendaDisplay = document.getElementById('dendaDisplay');
        const dendaHidden = document.getElementById('dendaHidden');
        const totalBayarDisplay = document.getElementById('totalBayarDisplay');
        const totalBayarHidden = document.getElementById('totalBayarHidden');

        function hitungDendaDiskon() {
            if (!tglPengembalianInput.value) return;

            const jamPengembalian = document.getElementById('jam_pengembalian').value;
            // Ambil jam kembali dari PHP (readonly, sudah ada di form)
            const jamKembali = "<?= isset($row['jam_kembali']) ? $row['jam_kembali'] : '' ?>";
            const tglKembaliStr = document.querySelector('input[name="tgl_kembali_asli"]').value;

            // Gabungkan tanggal dan jam kembali
            const tglJamKembali = new Date(tglKembaliStr + 'T' + (jamKembali ? jamKembali : '00:00'));
            // Gabungkan tanggal dan jam pengembalian
            const tglJamPengembalian = new Date(tglPengembalianInput.value + 'T' + (jamPengembalian ? jamPengembalian : '00:00'));

            let denda = 0;
            let totalBayar = hargaSewa;
            let selisihMs = tglJamPengembalian - tglJamKembali;
            let selisihJam = selisihMs / (1000 * 60 * 60);

            if (selisihJam > 0) {
                if (selisihJam < 24) {
                    denda = Math.ceil(selisihJam) * (hargaSewa * 0.10);
                    dendaDisplay.value = `+ Rp ${denda.toLocaleString('id-ID')} (Denda ${Math.ceil(selisihJam)} jam x 10%)`;
                } else {
                    let hari = Math.floor(selisihJam / 24);
                    let sisaJam = selisihJam % 24;
                    denda = hari * hargaSewa + Math.ceil(sisaJam) * (hargaSewa * 0.10);
                    dendaDisplay.value = `+ Rp ${denda.toLocaleString('id-ID')} (Denda ${hari} hari & ${Math.ceil(sisaJam)} jam)`;
                }
                totalBayar = hargaSewa + denda;
            } else if (selisihJam < 0) {
                denda = 0;
                totalBayar = hargaSewa;
                dendaDisplay.value = 'Rp 0';
            } else {
                dendaDisplay.value = 'Rp 0';
            }

            dendaHidden.value = denda;
            totalBayarDisplay.value = `Rp ${totalBayar.toLocaleString('id-ID')}`;
            totalBayarHidden.value = totalBayar;
        }

        tglPengembalianInput.addEventListener('change', hitungDendaDiskon);
        document.getElementById('jam_pengembalian').addEventListener('change', hitungDendaDiskon);

        if (typeof flatpickr !== 'undefined') {
            flatpickr("#jam_pengembalian", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                clickOpens: true,
                allowInput: false
            });
        }
    });
    </script>

    <style>
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

