<?php
require('fpdf/fpdf.php');

// Ambil data dari form
$id_sewa = $_POST['id_sewa'];
$id_customer = $_POST['id_customer'];
$id_mobil = $_POST['id_mobil'];
$tlg_sewa = $_POST['tlg_sewa'];
$tgl_kembali = $_POST['tgl_kembali'];
$tgl_pengembalian = $_POST['tgl_pengembalian'];
$harga = $_POST['harga'];
$denda = $_POST['denda'];
$total_harga = $_POST['total_harga'];
$bayar = $_POST['bayar'];
$uang_kembali = $_POST['uang_kembali'];
$status = $_POST['status'];

// Buat PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Laporan Sewa Mobil', 0, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function FormContent($data)
    {
        $this->SetFont('Arial', '', 12);
        foreach ($data as $key => $value) {
            $this->Cell(50, 10, ucfirst(str_replace('_', ' ', $key)), 1);
            $this->Cell(0, 10, $value, 1, 1);
        }
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->FormContent([
    'ID Sewa' => $id_sewa,
    'ID Customer' => $id_customer,
    'ID Mobil' => $id_mobil,
    'Tanggal Sewa' => $tlg_sewa,
    'Tanggal Kembali' => $tgl_kembali,
    'Tanggal Pengembalian' => $tgl_pengembalian,
    'Harga' => $harga,
    'Denda' => $denda,
    'Total Harga' => $total_harga,
    'Bayar' => $bayar,
    'Uang Kembali' => $uang_kembali,
    'Status' => $status,
]);

$pdf->Output('D', 'Laporan_Sewa_Mobil.pdf');

// Buat Gambar
$width = 800;
$height = 600;
$image = imagecreatetruecolor($width, $height);
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, $width, $height, $white);

$font = __DIR__ . '/arial.ttf'; // Path ke font TTF
$fontSize = 12;
$y = 50;
foreach ([
    'ID Sewa' => $id_sewa,
    'ID Customer' => $id_customer,
    'ID Mobil' => $id_mobil,
    'Tanggal Sewa' => $tlg_sewa,
    'Tanggal Kembali' => $tgl_kembali,
    'Tanggal Pengembalian' => $tgl_pengembalian,
    'Harga' => $harga,
    'Denda' => $denda,
    'Total Harga' => $total_harga,
    'Bayar' => $bayar,
    'Uang Kembali' => $uang_kembali,
    'Status' => $status,
] as $key => $value) {
    imagettftext($image, $fontSize, 0, 50, $y, $black, $font, ucfirst(str_replace('_', ' ', $key)) . ': ' . $value);
    $y += 30;
}

header('Content-Type: image/png');
imagepng($image, 'Laporan_Sewa_Mobil.png');
imagedestroy($image);

echo '<a href="Laporan_Sewa_Mobil.png" download>Download Gambar</a>';
?>