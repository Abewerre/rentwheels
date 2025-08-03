<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke dashboard
    header('Location: dashboard.php');
} else {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
}
exit();
?>
