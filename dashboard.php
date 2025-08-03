<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke login
    header('Location: login.php');
    exit();
}

// Lanjutkan dengan konten dashboard
?>

<!-- HTML content --> 