<?php
    include 'koneksi.php';
?>

<html>
<head>
  <title>Stock Barang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
			<h2>Laporan</h2>
			
				<div class="data-tables datatable-dark">
					
					<!-- Masukkan table nya disini, dimulai dari tag TABLE -->
                    <?php
include 'koneksi.php';

// Ambil semua id_sewa dan id_customer dari tabel sewa
$sql = "SELECT id_sewa, id_customer, id_mobil, tlg_sewa, tgl_kembali, tgl_pengembalian, harga, denda, uang_kembali, bayar, status FROM sewa";
$result = $conn->query($sql);

if ($result === false) {
    // Jika query gagal, tampilkan pesan kesalahan
    echo "Error: " . $conn->error;
} else {
    $id_sewa_options = [];
    $id_customer_map = [];
    $id_mobil_map = [];
    $tlg_sewa_map = [];
    $tgl_kembali_map = [];
    $tgl_pengembalian_map = [];
    $harga_map = [];
    $denda_map = [];
    $bayar_map = [];
    $uang_kembali_map = [];
    $status_map = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_sewa_options[] = $row['id_sewa'];
            $id_customer_map[$row['id_sewa']] = $row['id_customer'];
            $id_mobil_map[$row['id_sewa']] = $row['id_mobil'];
            $tlg_sewa_map[$row['id_sewa']] = $row['tlg_sewa'];
            $tgl_kembali_map[$row['id_sewa']] = $row['tgl_kembali'];
            $tgl_pengembalian_map[$row['id_sewa']] = $row['tgl_pengembalian'];
            $harga_map[$row['id_sewa']] = $row['harga'];
            $denda_map[$row['id_sewa']] = $row['denda'];
            $bayar_map[$row['id_sewa']] = $row['bayar'];
            $uang_kembali_map[$row['id_sewa']] = $row['uang_kembali'];
            $status_map[$row['id_sewa']] = $row['status'];
        }
    }
}
?>
                            
    <form action="export.php" method="post" id="exportForm">
    <!-- Form fields -->
    <div class="form-group">
        <label for="id_sewa">ID Sewa</label>
        <select class="form-control" id="id_sewa" name="id_sewa" required>
            <option value="">Pilih ID Sewa</option>
            <?php foreach ($id_sewa_options as $id_sewa_option): ?>
                <option value="<?php echo $id_sewa_option; ?>"><?php echo $id_sewa_option; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="id_customer">ID Customer</label>
        <input type="text" class="form-control" id="id_customer" name="id_customer" required>
    </div>
    <div class="form-group">
        <label for="id_mobil">ID Mobil</label>
        <input type="text" class="form-control" id="id_mobil" name="id_mobil" required>
    </div>
    <div class="form-group">
        <label for="tlg_sewa">Tanggal Sewa</label>
        <input type="text" class="form-control" id="tlg_sewa" name="tlg_sewa" required>
    </div>
    <div class="form-group">
        <label for="tgl_kembali">Tanggal Kembali</label>
        <input type="text" class="form-control" id="tgl_kembali" name="tgl_kembali" required>
    </div>
    <div class="form-group">
        <label for="tgl_pengembalian">Tanggal Pengembalian</label>
        <input type="text" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" required>
    </div>
    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" required>
    </div>
    <div class="form-group">
        <label for="denda">Denda</label>
        <input type="number" class="form-control" id="denda" name="denda" required>
    </div>
    <div class="form-group">
        <label for="total_harga">Total Harga</label>
        <input type="number" class="form-control" id="total_harga" name="total_harga" required>
    </div>
    <div class="form-group">
        <label for="bayar">Bayar</label>
        <input type="number" class="form-control" id="bayar" name="bayar" required>
    </div>
    <div class="form-group">
        <label for="uang_kembali">Uang Kembali</label>
        <input type="number" class="form-control" id="uang_kembali" name="uang_kembali" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <input type="text" class="form-control" id="status" name="status" required>
    </div>
    <button type="button" id="downloadPdf" class="btn btn-primary">Download PDF</button>
</form>
   




<script>
document.getElementById('id_sewa').addEventListener('change', function() {
    var id_sewa = this.value;
    var id_customer_map = <?php echo json_encode($id_customer_map); ?>;
    var id_mobil_map = <?php echo json_encode($id_mobil_map); ?>;
    var tlg_sewa_map = <?php echo json_encode($tlg_sewa_map); ?>;
    var tgl_kembali_map = <?php echo json_encode($tgl_kembali_map); ?>;
    var tgl_pengembalian_map = <?php echo json_encode($tgl_pengembalian_map); ?>;
    var harga_map = <?php echo json_encode($harga_map); ?>;
    var denda_map = <?php echo json_encode($denda_map); ?>;
    var bayar_map = <?php echo json_encode($bayar_map); ?>;
    var uang_kembali_map = <?php echo json_encode($uang_kembali_map); ?>;
    var status_map = <?php echo json_encode($status_map); ?>;
    if (id_sewa) {
        document.getElementById('id_customer').value = id_customer_map[id_sewa];
        document.getElementById('id_mobil').value = id_mobil_map[id_sewa];
        document.getElementById('tlg_sewa').value = tlg_sewa_map[id_sewa];
        document.getElementById('tgl_kembali').value = tgl_kembali_map[id_sewa];
        document.getElementById('tgl_pengembalian').value = tgl_pengembalian_map[id_sewa];
        document.getElementById('harga').value = harga_map[id_sewa];
        document.getElementById('denda').value = denda_map[id_sewa];
        document.getElementById('total_harga').value = parseFloat(harga_map[id_sewa]) + parseFloat(denda_map[id_sewa]);
        document.getElementById('bayar').value = bayar_map[id_sewa];
        document.getElementById('uang_kembali').value = uang_kembali_map[id_sewa];
        document.getElementById('status').value = status_map[id_sewa];
    }
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF();

    var id_sewa = document.getElementById('id_sewa').value;
    var id_customer = document.getElementById('id_customer').value;
    var id_mobil = document.getElementById('id_mobil').value;
    var tlg_sewa = document.getElementById('tlg_sewa').value;
    var tgl_kembali = document.getElementById('tgl_kembali').value;
    var tgl_pengembalian = document.getElementById('tgl_pengembalian').value;
    var harga = document.getElementById('harga').value;
    var denda = document.getElementById('denda').value;
    var total_harga = document.getElementById('total_harga').value;
    var bayar = document.getElementById('bayar').value;
    var uang_kembali = document.getElementById('uang_kembali').value;
    var status = document.getElementById('status').value;

    doc.text(`ID Sewa: ${id_sewa}`, 10, 10);
    doc.text(`ID Customer: ${id_customer}`, 10, 20);
    doc.text(`ID Mobil: ${id_mobil}`, 10, 30);
    doc.text(`Tanggal Sewa: ${tlg_sewa}`, 10, 40);
    doc.text(`Tanggal Kembali: ${tgl_kembali}`, 10, 50);
    doc.text(`Tanggal Pengembalian: ${tgl_pengembalian}`, 10, 60);
    doc.text(`Harga: ${harga}`, 10, 70);
    doc.text(`Denda: ${denda}`, 10, 80);
    doc.text(`Total Harga: ${total_harga}`, 10, 90);
    doc.text(`Bayar: ${bayar}`, 10, 100);
    doc.text(`Uang Kembali: ${uang_kembali}`, 10, 110);
    doc.text(`Status: ${status}`, 10, 120);

    doc.save('form-data.pdf');
});
</script>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#export').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>