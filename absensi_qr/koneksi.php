<?php

$host = "fdb1030.awardspace.net";
$user = "4780645_absensi";
$password = "Shilmi2001";
$database = "4780645_absensi";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>