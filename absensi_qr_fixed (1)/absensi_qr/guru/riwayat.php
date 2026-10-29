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

/* =====================================
   RIWAYAT ABSENSI
===================================== */

$query=mysqli_query($koneksi,"
SELECT
absensi.*,
siswa.nis,
siswa.nama_siswa,
kelas.nama_kelas,
mapel.nama_mapel
FROM absensi
INNER JOIN siswa
ON siswa.id_siswa=absensi.id_siswa
INNER JOIN jadwal
ON jadwal.id_jadwal=absensi.id_jadwal
INNER JOIN kelas
ON kelas.id_kelas=jadwal.id_kelas
INNER JOIN mapel
ON mapel.id_mapel=jadwal.id_mapel
WHERE jadwal.id_guru='$idGuru'
ORDER BY
absensi.tanggal DESC,
absensi.jam_masuk DESC
");

?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-8">

<h2 class="fw-bold">

Riwayat Absensi

</h2>

<p class="text-secondary">

Riwayat seluruh absensi siswa.

</p>

</div>

<div class="col-md-4 text-end">

<span class="badge bg-success fs-6">

<?= date("d-m-Y"); ?>

</span>

</div>

</div>
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <div>

            <i class="fa-solid fa-clock-rotate-left text-success"></i>

            Data Riwayat Absensi

        </div>

        <span class="badge bg-success">

            <?= mysqli_num_rows($query); ?> Data

        </span>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover table-striped datatable">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>NIS</th>

                        <th>Nama Siswa</th>

                        <th>Kelas</th>

                        <th>Mapel</th>

                        <th>Jam Masuk</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

<?php

$no=1;

if(mysqli_num_rows($query)>0){

while($d=mysqli_fetch_assoc($query)){

?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date('d-m-Y',strtotime($d['tanggal'])) ?></td>
    <td><?= $d['nis'] ?></td>
    <td><?= $d['nama_siswa'] ?></td>
    <td><?= $d['nama_kelas'] ?></td>
    <td><?= $d['nama_mapel'] ?></td>
    <td><?= substr($d['jam_masuk'],0,5) ?></td>
    <td><?= $d['status'] ?></td>
</tr>

<tr>

    <td><?= $no++ ?></td>

    <td><?= date('d-m-Y',strtotime($d['tanggal'])) ?></td>

    <td><?= htmlspecialchars($d['nis']) ?></td>

    <td><?= htmlspecialchars($d['nama_siswa']) ?></td>

    <td><?= htmlspecialchars($d['nama_kelas']) ?></td>

    <td><?= htmlspecialchars($d['nama_mapel']) ?></td>

    <td><?= substr($d['jam_masuk'],0,5) ?></td>

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
                echo "<span class='badge bg-danger'>".$d['status']."</span>";

        }

        ?>

    </td>

</tr>
<?php

}

}else{

?>

<tr>

<td colspan="8" class="text-center">
    Belum ada data
</td>

</tr>

<?php

}

?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

</div>

<?php include "layout/footer.php"; ?>