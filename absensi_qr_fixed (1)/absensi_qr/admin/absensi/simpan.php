<?php

session_start();
require_once "../../config/koneksi.php";

header('Content-Type: application/json');

if (!isset($_GET['nis']) || !isset($_GET['id_jadwal'])) {
    echo json_encode([
        "status" => false,
        "pesan" => "Data tidak lengkap."
    ]);
    exit;
}

$nis = mysqli_real_escape_string($koneksi, $_GET['nis']);
$id_jadwal = (int)$_GET['id_jadwal'];

$tanggal = date("Y-m-d");
$jam = date("H:i:s");
$status = "Hadir";

$qSiswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");

if(mysqli_num_rows($qSiswa)==0){

    echo json_encode([
        "status"=>false,
        "pesan"=>"QR Code tidak terdaftar."
    ]);
    exit;

}

$siswa=mysqli_fetch_assoc($qSiswa);

$id_siswa=$siswa['id_siswa'];

$cek=mysqli_query($koneksi,"
SELECT *
FROM absensi
WHERE
id_siswa='$id_siswa'
AND id_jadwal='$id_jadwal'
AND tanggal='$tanggal'
");

if(mysqli_num_rows($cek)>0){

    echo json_encode([
        "status"=>false,
        "pesan"=>"Siswa sudah melakukan absensi."
    ]);
    exit;

}

$simpan=mysqli_query($koneksi,"
INSERT INTO absensi
(id_siswa,id_jadwal,tanggal,jam_masuk,status)

VALUES

('$id_siswa','$id_jadwal','$tanggal','$jam','$status')
");

if($simpan){

    echo json_encode([
        "status"=>true,
        "pesan"=>"Absensi berhasil disimpan.",
        "nama"=>$siswa['nama_siswa']
    ]);

}else{

    echo json_encode([
        "status"=>false,
        "pesan"=>"Gagal menyimpan absensi."
    ]);

}