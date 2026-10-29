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
    header("Location: mapel.php");
    exit;
}

$id = intval($_GET['id']);

/* ==========================================
   CEK DATA MAPEL
========================================== */

$qMapel = mysqli_query($koneksi,"
SELECT *
FROM mapel
WHERE id_mapel='$id'
");

if(mysqli_num_rows($qMapel)==0){

    header("Location: mapel.php");
    exit;

}

$mapel = mysqli_fetch_assoc($qMapel);

/* ==========================================
   CEK RELASI KE JADWAL
========================================== */

$cekJadwal = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM jadwal
WHERE id_mapel='$id'
");

$dataJadwal = mysqli_fetch_assoc($cekJadwal);

if($dataJadwal['total'] > 0){

    echo "<script>

    alert('Mata pelajaran tidak dapat dihapus karena masih digunakan pada jadwal.');

    window.location='mapel.php';

    </script>";

    exit;

}

/* ==========================================
   HAPUS DATA
========================================== */

$hapus = mysqli_query($koneksi,"
DELETE FROM mapel
WHERE id_mapel='$id'
");

if($hapus){

    echo "<script>

    alert('Data mata pelajaran berhasil dihapus.');

    window.location='mapel.php';

    </script>";

}else{

    echo "<script>

    alert('Gagal menghapus data.');

    window.location='mapel.php';

    </script>";

}