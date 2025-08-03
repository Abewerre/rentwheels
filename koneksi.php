<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Matikan strict mode dan ONLY_FULL_GROUP_BY
mysqli_query($conn, "SET GLOBAL sql_mode=''");
mysqli_query($conn, "SET SESSION sql_mode=''");

