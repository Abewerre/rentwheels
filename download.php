<?php
// Pastikan tidak ada output apapun sebelum generate PDF
ob_clean(); // Membersihkan output buffer
include 'koneksi.php';
require('fpdf/fpdf.php');

if(isset($_GET['id_sewa'])) {
    $id_sewa = $_GET['id_sewa'];
    
    $sql = "SELECT s.*, c.nama_customer, m.merk, m.no_plat 
            FROM sewa s
            JOIN customer c ON s.id_customer = c.id_customer
            JOIN mobil m ON s.id_mobil = m.id_mobil
            WHERE s.id_sewa = '$id_sewa'";
            
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Cek status sebelum generate PDF
        if($row['status'] != "Selesai") {
            die("Maaf, laporan hanya bisa didownload untuk transaksi yang sudah selesai.");
        }
        
        $total_harga = $row['harga'] + $row['denda'];
        
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        
        // Header Modern
        $pdf->SetFont('Arial','B',18);
        $pdf->SetTextColor(40, 53, 147);
        $pdf->Cell(190,12,'RENT WHEELS',0,1,'C');
        $pdf->SetFont('Arial','B',14);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(190,8,'LAPORAN TRANSAKSI SEWA MOBIL',0,1,'C');
        $pdf->SetDrawColor(40, 53, 147);
        $pdf->SetLineWidth(1);
        $pdf->Line(10,32,200,32);
        $pdf->Ln(10);
        
        // Informasi Sewa
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'ID Sewa',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130,8,$row['id_sewa'],0,1);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'Nama Customer',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130,8,$row['nama_customer'],0,1);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'Mobil',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(130,8,$row['merk'] . ' (' . $row['no_plat'] . ')',0,1);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'Tanggal Sewa',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(60,8,$row['tlg_sewa'],0,0);
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(30,8,'Jam Sewa',0,0,'R');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,8,isset($row['jam_sewa']) && $row['jam_sewa'] ? date('H:i', strtotime($row['jam_sewa'])) : '-',0,1);
        
        // Tanggal & Jam Kembali
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'Tanggal Kembali',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(60,8,$row['tgl_kembali'],0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(30,8,'Jam Kembali',0,0,'R');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,8,isset($row['jam_kembali']) && $row['jam_kembali'] ? date('H:i', strtotime($row['jam_kembali'])) : '-',0,1);
        
        // Tanggal Pengembalian & Jam Pengembalian (satu baris, rapi)
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(60,8,'Tanggal Pengembalian',0,0);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(60,8,$row['tgl_pengembalian'],0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(30,8,'Jam Pengembalian',0,0,'R');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,8,isset($row['jam_pengembalian']) && $row['jam_pengembalian'] ? date('H:i', strtotime($row['jam_pengembalian'])) : '-',0,1);
        
        $pdf->Ln(5);
        $pdf->SetDrawColor(200,200,200);
        $pdf->SetLineWidth(0.5);
        $pdf->Line(10,$pdf->GetY(),200,$pdf->GetY());
        $pdf->Ln(8);
        
        // Informasi Pembayaran
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,8,'RINCIAN PEMBAYARAN',0,1,'C');
        $pdf->SetFont('Arial','',12);
        
        $pdf->Cell(60,8,'Harga Sewa',0,0);
        $pdf->Cell(130,8,'Rp. ' . number_format($row['harga'],0,',','.'),0,1);
        
        $pdf->Cell(60,8,'Denda',0,0);
        $pdf->Cell(130,8,'Rp. ' . number_format($row['denda'],0,',','.'),0,1);
        
        $pdf->Cell(60,8,'Total Harga',0,0);
        $pdf->Cell(130,8,'Rp. ' . number_format($total_harga,0,',','.'),0,1);
        
        $pdf->Cell(60,8,'Status',0,0);
        $pdf->Cell(130,8,$row['status'],0,1);
        
        // Catatan denda
        if($row['denda'] > 0) {
            $pdf->Ln(5);
            $pdf->SetFont('Arial','I',11);
            $pdf->SetTextColor(220,53,69);
            $pdf->MultiCell(190,8,'Catatan: Denda dikenakan karena keterlambatan pengembalian. Besaran denda sesuai aturan yang berlaku.',0,'L');
            $pdf->SetTextColor(0,0,0);
        }
        
        // Output PDF
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('I', 'Laporan_Sewa_'.$id_sewa.'.pdf');
        exit;
    } else {
        echo "Data tidak ditemukan";
    }
} else {
    echo "ID Sewa tidak ditemukan";
}
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