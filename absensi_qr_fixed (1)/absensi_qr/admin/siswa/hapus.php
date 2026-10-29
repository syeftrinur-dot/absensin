<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if(!isset($_GET['id'])){
    die("ID tidak ditemukan.");
}

$id = (int)$_GET['id'];

/* Ambil data siswa terlebih dahulu */
$data = mysqli_query($koneksi,"SELECT * FROM siswa WHERE id_siswa='$id'");

if(mysqli_num_rows($data)==0){
    die("Data siswa tidak ditemukan.");
}

$siswa = mysqli_fetch_assoc($data);

/* Hapus file QR jika ada */
if(!empty($siswa['qr_code']) && file_exists("../../".$siswa['qr_code'])){
    unlink("../../".$siswa['qr_code']);
}

/* Hapus data siswa */
$hapus = mysqli_query($koneksi,"DELETE FROM siswa WHERE id_siswa='$id'");

if($hapus){

    echo "<script>
            alert('Data siswa berhasil dihapus.');
            window.location='index.php';
          </script>";

}else{

    echo "<script>
            alert('Data gagal dihapus.');
            window.location='index.php';
          </script>";

}