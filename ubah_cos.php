<?php
include 'koneksi.php';
// Menangani pengiriman form

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_customer = $_POST['id_customer']; // ubah no_ktp menjadi id_customer


    $nama_customer = $_POST['nama_customer']; // ubah nama_pelanggan menjadi nama_customer


    $gender = $_POST['gender'];


    $no_telpon = $_POST['no_telpon'];

    $alamat = $_POST['alamat'];


    // Update data customer

    $sql = "UPDATE customer SET nama_customer='$nama_customer', gender='$gender', no_telpon='$no_telpon', alamat='$alamat' WHERE id_customer='$id_customer'"; // ubah tabel pelanggan menjadi customer dan kolom sesuai


    if ($conn->query($sql) === TRUE) {


        echo "<script>

                alert('Data customer berhasil diubah');
                window.location.href = 'costumer.php';
              </script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;

    }
}


$conn->close();
?>