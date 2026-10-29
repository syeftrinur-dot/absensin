<?php

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="siswa"){

    header("Location: ../login.php");
    exit;

}

include "../koneksi.php";

$idSiswa = $_SESSION['id_siswa'];

/* ===========================
   AMBIL FOTO LAMA
=========================== */

$q = mysqli_query($koneksi,"
SELECT foto
FROM siswa
WHERE id_siswa='$idSiswa'
");

$data = mysqli_fetch_assoc($q);

/* ===========================
   VALIDASI FILE
=========================== */

if(!isset($_FILES['foto'])){

    header("Location: profil.php");
    exit;

}

$file = $_FILES['foto'];

$namaFile = $file['name'];
$tmp      = $file['tmp_name'];
$ukuran   = $file['size'];
$error    = $file['error'];

if($error != 0){

    echo "<script>
    alert('Gagal mengupload file.');
    window.location='profil.php';
    </script>";
    exit;

}

$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

$allowed = ['jpg','jpeg','png'];

if(!in_array($ext,$allowed)){

    echo "<script>
    alert('Format file harus JPG, JPEG atau PNG.');
    window.location='profil.php';
    </script>";
    exit;

}

if($ukuran > 2 * 1024 * 1024){

    echo "<script>
    alert('Ukuran file maksimal 2 MB.');
    window.location='profil.php';
    </script>";
    exit;

}

/* ===========================
   SIMPAN FILE
=========================== */

$namaBaru = uniqid('siswa_').".".$ext;

$folder = "../assets/img/siswa/";

if(move_uploaded_file($tmp,$folder.$namaBaru)){

    if(!empty($data['foto']) &&
       file_exists($folder.$data['foto'])){

        unlink($folder.$data['foto']);

    }

    mysqli_query($koneksi,"
    UPDATE siswa
    SET foto='$namaBaru'
    WHERE id_siswa='$idSiswa'
    ");

    echo "<script>
    alert('Foto berhasil diperbarui.');
    window.location='profil.php';
    </script>";

}else{

    echo "<script>
    alert('Upload gagal.');
    window.location='profil.php';
    </script>";

}

?>