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

if(!isset($_GET['id'])){
    header("Location: jadwal.php");
    exit;
}

$id = intval($_GET['id']);

$cek = mysqli_query($koneksi,"
SELECT *
FROM jadwal
WHERE id_jadwal='$id'
");

if(mysqli_num_rows($cek)==0){

    header("Location: jadwal.php");
    exit;

}

$hapus = mysqli_query($koneksi,"
DELETE FROM jadwal
WHERE id_jadwal='$id'
");

if($hapus){

echo "<script>

alert('Jadwal berhasil dihapus.');

window.location='jadwal.php';

</script>";

}else{

echo "<script>

alert('Gagal menghapus jadwal.');

window.location='jadwal.php';

</script>";

}