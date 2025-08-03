<?php
   require('fpdf/fpdf.php');
   include 'koneksi.php';

   if (isset($_GET['id_sewa'])) {
       $id_sewa = $_GET['id_sewa'];

       $sql = "SELECT * FROM sewa WHERE id_sewa = $id_sewa";
       $result = $conn->query($sql);

       if ($result->num_rows > 0) {
           $row = $result->fetch_assoc();

           $pdf = new FPDF();
           $pdf->AddPage();
           $pdf->SetFont('Arial', 'B', 16);

           $pdf->Cell(40, 10, 'ID Sewa: ' . $row['id_sewa']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'ID Customer: ' . $row['id_customer']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'ID Mobil: ' . $row['id_mobil']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Harga: ' . $row['harga']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Denda: ' . $row['denda']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Tanggal Sewa: ' . $row['tlg_sewa']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Tanggal Kembali: ' . $row['tgl_kembali']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Tanggal Pengembalian: ' . $row['tgl_pengembalian']);
           $pdf->Ln();
           $pdf->Cell(40, 10, 'Status: ' . $row['status']);

           $pdf->Output();
       } else {
           echo "Data tidak ditemukan.";
       }
   } else {
       echo "ID Sewa tidak diberikan.";
   }

   $conn->close();
   ?>