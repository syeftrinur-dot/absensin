<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
include "../layout/header.php";
include "../layout/sidebar.php";

/* =====================================
   TANGGAL HARI INI
===================================== */

$hariIni = date('Y-m-d');

/* =====================================
   TOTAL DATA
===================================== */

function totalData($koneksi, $tabel)
{
    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM $tabel");
    $data = mysqli_fetch_assoc($query);
    return $data['total'];
}

$totalGuru   = totalData($koneksi, "guru");
$totalSiswa  = totalData($koneksi, "siswa");
$totalKelas  = totalData($koneksi, "kelas");
$totalMapel  = totalData($koneksi, "mapel");
$totalJadwal = totalData($koneksi, "jadwal");

/* =====================================
   ABSENSI HARI INI
===================================== */

$qAbsen = mysqli_query($koneksi,"
SELECT COUNT(*) AS total
FROM absensi
WHERE tanggal='$hariIni'
");

$totalAbsensi = mysqli_fetch_assoc($qAbsen)['total'];

/* =====================================
   STATUS ABSENSI
===================================== */

function totalStatus($koneksi,$status,$tanggal)
{
    $q=mysqli_query($koneksi,"
    SELECT COUNT(*) AS total
    FROM absensi
    WHERE tanggal='$tanggal'
    AND status='$status'
    ");

    return mysqli_fetch_assoc($q)['total'];
}

$hadir = totalStatus($koneksi,"Hadir",$hariIni);
$izin  = totalStatus($koneksi,"Izin",$hariIni);
$sakit = totalStatus($koneksi,"Sakit",$hariIni);
$alpha = totalStatus($koneksi,"Alpha",$hariIni);

/* =====================================
   GRAFIK 7 HARI
===================================== */

$labelGrafik = [];
$dataGrafik = [];

for($i=6;$i>=0;$i--){

    $tgl=date('Y-m-d',strtotime("-$i day"));

    $labelGrafik[] = date('d M',strtotime($tgl));

    $q=mysqli_query($koneksi,"
    SELECT COUNT(*) total
    FROM absensi
    WHERE tanggal='$tgl'
    ");

    $hasil=mysqli_fetch_assoc($q);

    $dataGrafik[]=$hasil['total'];

}
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Dashboard Administrator

</h2>

<p class="text-secondary">

Selamat datang,

<b><?= htmlspecialchars($_SESSION['nama']); ?></b>

</p>

</div>

<div class="col-md-4 text-end">

<span class="badge bg-primary fs-6">

<?= date('d F Y'); ?>

</span>

</div>

</div>

<div class="row g-4">
<!-- ==========================
     CARD GURU
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card primary">

        <div class="dashboard-title">

            Total Guru

        </div>

        <div class="dashboard-number">

            <?= $totalGuru ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-chalkboard-user"></i>

        </div>

    </div>

</div>

<!-- ==========================
     CARD SISWA
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card success">

        <div class="dashboard-title">

            Total Siswa

        </div>

        <div class="dashboard-number">

            <?= $totalSiswa ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-user-graduate"></i>

        </div>

    </div>

</div>

<!-- ==========================
     CARD KELAS
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card warning">

        <div class="dashboard-title">

            Total Kelas

        </div>

        <div class="dashboard-number">

            <?= $totalKelas ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-school"></i>

        </div>

    </div>

</div>

<!-- ==========================
     CARD MAPEL
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card info">

        <div class="dashboard-title">

            Mata Pelajaran

        </div>

        <div class="dashboard-number">

            <?= $totalMapel ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-book-open"></i>

        </div>

    </div>

</div>

<!-- ==========================
     CARD JADWAL
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card secondary">

        <div class="dashboard-title">

            Jadwal

        </div>

        <div class="dashboard-number">

            <?= $totalJadwal ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-calendar-days"></i>

        </div>

    </div>

</div>

<!-- ==========================
     CARD ABSENSI
========================== -->

<div class="col-xl-2 col-lg-4 col-md-6">

    <div class="dashboard-card danger">

        <div class="dashboard-title">

            Absensi Hari Ini

        </div>

        <div class="dashboard-number">

            <?= $totalAbsensi ?>

        </div>

        <div class="dashboard-icon">

            <i class="fa-solid fa-clipboard-check"></i>

        </div>

    </div>

</div>

</div>

<!-- END ROW -->
 <!-- ==================================================
     STATUS KEHADIRAN & GRAFIK
================================================== -->

<div class="row mt-4">

    <!-- STATUS KEHADIRAN -->

    <div class="col-lg-4 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <i class="fa-solid fa-chart-pie text-primary"></i>

                Status Kehadiran Hari Ini

            </div>

            <div class="card-body">

                <?php

                $totalStatus = $hadir + $izin + $sakit + $alpha;

                if($totalStatus==0){
                    $totalStatus=1;
                }

                ?>

                <!-- HADIR -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between">

                        <span>

                            <i class="fa-solid fa-circle text-success"></i>

                            Hadir

                        </span>

                        <strong><?= $hadir ?></strong>

                    </div>

                    <div class="progress mt-2">

                        <div
                        class="progress-bar bg-success"
                        style="width:<?= ($hadir/$totalStatus)*100 ?>%">

                        </div>

                    </div>

                </div>

                <!-- IZIN -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between">

                        <span>

                            <i class="fa-solid fa-circle text-warning"></i>

                            Izin

                        </span>

                        <strong><?= $izin ?></strong>

                    </div>

                    <div class="progress mt-2">

                        <div
                        class="progress-bar bg-warning"
                        style="width:<?= ($izin/$totalStatus)*100 ?>%">

                        </div>

                    </div>

                </div>

                <!-- SAKIT -->

                <div class="mb-4">

                    <div class="d-flex justify-content-between">

                        <span>

                            <i class="fa-solid fa-circle text-info"></i>

                            Sakit

                        </span>

                        <strong><?= $sakit ?></strong>

                    </div>

                    <div class="progress mt-2">

                        <div
                        class="progress-bar bg-info"
                        style="width:<?= ($sakit/$totalStatus)*100 ?>%">

                        </div>

                    </div>

                </div>

                <!-- ALPHA -->

                <div>

                    <div class="d-flex justify-content-between">

                        <span>

                            <i class="fa-solid fa-circle text-danger"></i>

                            Alpha

                        </span>

                        <strong><?= $alpha ?></strong>

                    </div>

                    <div class="progress mt-2">

                        <div
                        class="progress-bar bg-danger"
                        style="width:<?= ($alpha/$totalStatus)*100 ?>%">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- GRAFIK -->

    <div class="col-lg-8 mb-4">

        <div class="card h-100">

            <div class="card-header">

                <i class="fa-solid fa-chart-column text-success"></i>

                Grafik Absensi 7 Hari Terakhir

            </div>

            <div class="card-body">

                <canvas id="grafikAbsensi" height="120"></canvas>

            </div>

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('grafikAbsensi');

new Chart(ctx,{

type:'bar',

data:{

labels:<?= json_encode($labelGrafik); ?>,

datasets:[{

label:'Jumlah Absensi',

data:<?= json_encode($dataGrafik); ?>,

backgroundColor:[
'#2563eb',
'#2563eb',
'#2563eb',
'#2563eb',
'#2563eb',
'#2563eb',
'#2563eb'
],

borderRadius:10

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true,

ticks:{

precision:0

}

}

}

}

});

</script>
<!-- ============================================
     ABSENSI TERBARU
============================================= -->

<div class="row">

    <div class="col-lg-8 mb-4">

        <div class="card">

            <div class="card-header">

                <i class="fa-solid fa-clock-rotate-left text-primary"></i>

                5 Absensi Terbaru

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Nama</th>

                                <th>Kelas</th>

                                <th>Tanggal</th>

                                <th>Jam Masuk</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

<?php

$no=1;

$query = mysqli_query($koneksi,"
SELECT
    absensi.*,
    siswa.nama_siswa,
    siswa.kelas
FROM absensi
INNER JOIN siswa
    ON siswa.id_siswa = absensi.id_siswa
ORDER BY absensi.id_absensi DESC
LIMIT 5
");
while($d=mysqli_fetch_assoc($query)){

?>
<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($d['nama_siswa']) ?></td>

<td><?= htmlspecialchars($d['kelas']) ?></td>

<td><?= date('d-m-Y',strtotime($d['tanggal'])) ?></td>

<td><?= $d['jam_masuk'] ?></td>

<td>

<?php

switch($d['status']){

case "Hadir":

echo "<span class='badge bg-success'>Hadir</span>";

break;

case "Izin":

echo "<span class='badge bg-warning text-dark'>Izin</span>";

break;

case "Sakit":

echo "<span class='badge bg-info'>Sakit</span>";

break;

default:

echo "<span class='badge bg-danger'>Alpha</span>";

}

?>

</td>

</tr>

<?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- ==========================
         JADWAL HARI INI
    ========================== -->

    <div class="col-lg-4 mb-4">

        <div class="card">

            <div class="card-header">

                <i class="fa-solid fa-calendar-day text-success"></i>

                Jadwal Hari Ini

            </div>

            <div class="card-body">

<?php

$hari=date('l');

$query=mysqli_query($koneksi,"
SELECT
jadwal.*,
guru.nama_guru,
kelas.nama_kelas,
mapel.nama_mapel
FROM jadwal
JOIN guru ON guru.id_guru=jadwal.id_guru
JOIN kelas ON kelas.id_kelas=jadwal.id_kelas
JOIN mapel ON mapel.id_mapel=jadwal.id_mapel
WHERE hari='$hari'
ORDER BY jam_mulai
");

if(mysqli_num_rows($query)>0){

while($d=mysqli_fetch_assoc($query)){

?>

<div class="border rounded p-3 mb-3">

<b><?= $d['nama_mapel'] ?></b>

<br>

<small>

<?= $d['nama_guru'] ?>

</small>

<br>

<small>

<?= $d['nama_kelas'] ?>

</small>

<br>

<span class="badge bg-primary mt-2">

<?= substr($d['jam_mulai'],0,5) ?>

-

<?= substr($d['jam_selesai'],0,5) ?>

</span>

</div>

<?php

}

}else{

?>

<div class="alert alert-secondary mb-0">

Belum ada jadwal hari ini.

</div>

<?php } ?>

            </div>

        </div>

    </div>

</div>

</div>

</div>

<?php

include "../layout/footer.php";

?>