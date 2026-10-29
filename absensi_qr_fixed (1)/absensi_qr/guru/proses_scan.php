<?php
session_start();

include "../koneksi.php";

if(!isset($_POST['qr'])){

    exit;

}

$qr=mysqli_real_escape_string($koneksi,$_POST['qr']);

$idGuru=$_SESSION['id_guru'];

$hari=date("l");

$namaHari=array(

"Monday"=>"Senin",
"Tuesday"=>"Selasa",
"Wednesday"=>"Rabu",
"Thursday"=>"Kamis",
"Friday"=>"Jumat",
"Saturday"=>"Sabtu"

);

$hari=$namaHari[$hari];

$jam=date("H:i:s");

$tanggal=date("Y-m-d");

$siswa=mysqli_query($koneksi,"
SELECT *
FROM siswa
WHERE nis='$qr'
");

if(mysqli_num_rows($siswa)==0){

echo "<div class='alert alert-danger'>
QR tidak ditemukan
</div>";

exit;

}

$siswa=mysqli_fetch_assoc($siswa);

$jadwal=mysqli_query($koneksi,"
SELECT *
FROM jadwal
WHERE id_guru='$idGuru'
AND hari='$hari'
AND '$jam'
BETWEEN jam_mulai
AND jam_selesai
LIMIT 1
");

if(mysqli_num_rows($jadwal)==0){

echo "<div class='alert alert-warning'>
Tidak ada jadwal saat ini
</div>";

exit;

}

$jadwal=mysqli_fetch_assoc($jadwal);

$cek=mysqli_query($koneksi,"
SELECT *
FROM absensi
WHERE

id_siswa='".$siswa['id_siswa']."'

AND

id_jadwal='".$jadwal['id_jadwal']."'

AND

tanggal='$tanggal'
");

if(mysqli_num_rows($cek)>0){

echo "<div class='alert alert-warning'>

<b>".$siswa['nama_siswa']."</b>

<br>

Sudah melakukan absensi.

</div>";

exit;

}

mysqli_query($koneksi,"
INSERT INTO absensi

(

id_siswa,

id_jadwal,

tanggal,

jam_masuk,

status

)

VALUES

(

'".$siswa['id_siswa']."',

'".$jadwal['id_jadwal']."',

'$tanggal',

'$jam',

'Hadir'

)

");

echo "<div class='alert alert-success'>

<h4>ABSENSI BERHASIL</h4>

Nama :

<b>".$siswa['nama_siswa']."</b>

<br>

Kelas :

".$siswa['kelas']."

</div>";