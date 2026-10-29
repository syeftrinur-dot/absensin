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

if (!isset($_GET['id'])) {
    header("Location: kelas.php");
    exit;
}

$id = intval($_GET['id']);

/* ==========================================
   CEK DATA KELAS
========================================== */

$qKelas = mysqli_query($koneksi,"
SELECT *
FROM kelas
WHERE id_kelas='$id'
");

if(mysqli_num_rows($qKelas)==0){

    header("Location: kelas.php");
    exit;

}

$kelas = mysqli_fetch_assoc($qKelas);

$namaKelas = $kelas['nama_kelas'];

/* ==========================================
   CEK DIGUNAKAN OLEH SISWA
========================================== */

$cekSiswa = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM siswa
WHERE kelas='$namaKelas'
");

$dataSiswa = mysqli_fetch_assoc($cekSiswa);

if($dataSiswa['total'] > 0){

    echo "<script>

    alert('Kelas tidak dapat dihapus karena masih digunakan oleh data siswa.');

    window.location='kelas.php';

    </script>";

    exit;

}

/* ==========================================
   CEK DIGUNAKAN OLEH JADWAL
========================================== */

$cekJadwal = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM jadwal
WHERE id_kelas='$id'
");

$dataJadwal = mysqli_fetch_assoc($cekJadwal);

if($dataJadwal['total'] > 0){

    echo "<script>

    alert('Kelas tidak dapat dihapus karena masih digunakan pada jadwal.');

    window.location='kelas.php';

    </script>";

    exit;

}

/* ==========================================
   HAPUS DATA
========================================== */

$hapus = mysqli_query($koneksi,"
DELETE FROM kelas
WHERE id_kelas='$id'
");

if($hapus){

    echo "<script>

    alert('Data kelas berhasil dihapus.');

    window.location='kelas.php';

    </script>";

}else{

    echo "<script>

    alert('Gagal menghapus data.');

    window.location='kelas.php';

    </script>";

}

?>