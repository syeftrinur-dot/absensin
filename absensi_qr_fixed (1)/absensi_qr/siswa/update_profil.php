<?php

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";

$idSiswa=$_SESSION['id_siswa'];

$nama=mysqli_real_escape_string($koneksi,$_POST['nama_siswa']);

$alamat=mysqli_real_escape_string($koneksi,$_POST['alamat']);

mysqli_query($koneksi,"

UPDATE siswa

SET

nama_siswa='$nama',

alamat='$alamat'

WHERE

id_siswa='$idSiswa'

");

$_SESSION['nama']=$nama;

echo "

<script>

alert('Profil berhasil diperbarui');

window.location='profil.php';

</script>

";

?>