<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi,"DELETE FROM guru WHERE id_guru='$id'");

header("Location:index.php");
exit;