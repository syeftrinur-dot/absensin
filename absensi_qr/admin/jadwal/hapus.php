<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM jadwal WHERE id_jadwal='$id'");

header("Location: index.php");
exit;