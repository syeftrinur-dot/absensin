<?php

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";

$idUser = $_SESSION['id_user'];

$passwordLama = md5($_POST['password_lama']);
$passwordBaru = md5($_POST['password_baru']);
$konfirmasi = md5($_POST['konfirmasi']);

if($passwordBaru != $konfirmasi){

    echo "<script>

    alert('Konfirmasi password tidak sama.');

    window.location='ganti_pasword.php';

    </script>";

    exit;

}

$cek = mysqli_query($koneksi,"
SELECT *
FROM users
WHERE id_user='$idUser'
AND password='$passwordLama'
");

if(mysqli_num_rows($cek)==0){

    echo "<script>

    alert('Password lama salah.');

    window.location='ganti_pasword.php';

    </script>";

    exit;

}

mysqli_query($koneksi,"
UPDATE users
SET password='$passwordBaru'
WHERE id_user='$idUser'
");

echo "<script>

alert('Password berhasil diubah.');

window.location='index.php';

</script>";

?>