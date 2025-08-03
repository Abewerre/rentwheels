<?php
$koneksi = mysqli_connect("localhost", "root", "", "rental");
// localhost = host database
// root = username default XAMPP/Laragon
// "" = password (kosong karena default XAMPP/Laragon tidak menggunakan password)
// rental_baru = nama database Anda

if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>