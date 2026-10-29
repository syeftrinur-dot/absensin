<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

if(!isset($_SESSION['login']) || $_SESSION['role']!="guru"){

    header("Location: ../login.php");

    exit;

}

include "../koneksi.php";

include "layout/header.php";

include "layout/sidebar.php";

$idGuru=$_SESSION['id_guru'];

$idJadwal=isset($_GET['id_jadwal']) ? intval($_GET['id_jadwal']) : 0;

if($idJadwal==0){

echo "<script>

alert('Jadwal tidak ditemukan');

window.location='jadwal.php';

</script>";

exit;

}

/* ==========================
   DATA JADWAL
========================== */

$q=mysqli_query($koneksi,"
SELECT
jadwal.*,
kelas.nama_kelas,
mapel.nama_mapel
FROM jadwal
JOIN kelas
ON kelas.id_kelas=jadwal.id_kelas
JOIN mapel
ON mapel.id_mapel=jadwal.id_mapel
WHERE
jadwal.id_jadwal='$idJadwal'
AND jadwal.id_guru='$idGuru'
");

if(mysqli_num_rows($q)==0){

die("Data jadwal tidak ditemukan.");

}

$jadwal=mysqli_fetch_assoc($q);

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Scan QR Absensi

</h2>

<p class="text-secondary">

<?= htmlspecialchars($jadwal['nama_mapel']); ?>

-

<?= htmlspecialchars($jadwal['nama_kelas']); ?>

</p>

</div>

<div class="col-md-4 text-end">

<a
href="jadwal.php"
class="btn btn-secondary">

<i class="fa fa-arrow-left"></i>

Kembali

</a>

</div>

</div>
<div class="row">

    <!-- ==========================
         SCANNER
    ========================== -->

    <div class="col-lg-7">

        <div class="card">

            <div class="card-header">

                <i class="fa-solid fa-camera"></i>

                Kamera Scanner QR

            </div>

            <div class="card-body text-center">

                <div id="reader" style="width:100%;max-width:600px;margin:auto;"></div>

                <div class="mt-3">

                    <span class="badge bg-primary">

                        Arahkan QR Code ke kamera

                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- ==========================
         INFORMASI
    ========================== -->

    <div class="col-lg-5">

        <div class="card">

            <div class="card-header">

                <i class="fa-solid fa-circle-info"></i>

                Informasi Jadwal

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>

                        <th width="120">Mapel</th>

                        <td>

                            <?= htmlspecialchars($jadwal['nama_mapel']) ?>

                        </td>

                    </tr>

                    <tr>

                        <th>Kelas</th>

                        <td>

                            <?= htmlspecialchars($jadwal['nama_kelas']) ?>

                        </td>

                    </tr>

                    <tr>

                        <th>Hari</th>

                        <td>

                            <?= htmlspecialchars($jadwal['hari']) ?>

                        </td>

                    </tr>

                    <tr>

                        <th>Jam</th>

                        <td>

                            <?= substr($jadwal['jam_mulai'],0,5) ?>

                            -

                            <?= substr($jadwal['jam_selesai'],0,5) ?>

                        </td>

                    </tr>

                </table>

                <hr>

                <div id="hasil">

                    <div class="alert alert-secondary mb-0">

                        Menunggu QR Code dipindai...

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- =====================================
     HTML5 QR CODE
====================================== -->

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

let scanner = new Html5Qrcode("reader");

let sudahScan = false;

function berhasilScan(qrCode){

    if(sudahScan) return;

    sudahScan = true;

    document.getElementById("hasil").innerHTML=
    '<div class="alert alert-info">Memproses absensi...</div>';

    fetch("simpan.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:
        "qr="+encodeURIComponent(qrCode)+
        "&id_jadwal=<?= $idJadwal ?>"

    })

    .then(res=>res.text())

    .then(function(data){

        document.getElementById("hasil").innerHTML=data;

        Swal.fire({

            icon:'success',

            title:'Berhasil',

            text:'Absensi berhasil disimpan',

            timer:1500,

            showConfirmButton:false

        });

        setTimeout(function(){

            location.reload();

        },1700);

    })

    .catch(function(){

        Swal.fire({

            icon:'error',

            title:'Gagal',

            text:'Terjadi kesalahan.'

        });

        sudahScan=false;

    });

}

scanner.start(

    { facingMode:"environment" },

    {

        fps:10,

        qrbox:250

    },

    berhasilScan,

    function(error){}

);

</script>

<?php

include "layout/footer.php";

?>