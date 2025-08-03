<?php
$servername = "mysql.railway.internal";
$username = "root";
$password = "kHDFoQjViwGzGDwRXQgPLGbiKGJURBaI";
$dbname = "railway";
$port = 3306;

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>