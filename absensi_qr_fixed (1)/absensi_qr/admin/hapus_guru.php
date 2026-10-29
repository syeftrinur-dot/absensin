<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../koneksi.php";

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    mysqli_query($koneksi,"
    DELETE FROM guru
    WHERE id_guru='$id'
    ");

}

header("Location: guru.php");
exit;