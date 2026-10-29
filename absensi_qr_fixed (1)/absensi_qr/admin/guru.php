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

/* ==============================
   PENCARIAN
============================== */

$cari = "";

$where = "";

if(isset($_GET['cari'])){

    $cari = mysqli_real_escape_string($koneksi,$_GET['cari']);

    $where = "WHERE
                nama_guru LIKE '%$cari%'
                OR nip LIKE '%$cari%'";

}

/* ==============================
   DATA GURU
============================== */

$query = mysqli_query($koneksi,"

SELECT *

FROM guru

$where

ORDER BY nama_guru ASC

");

$total = mysqli_num_rows($query);

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<div class="content">

<div class="container-fluid">

<div class="row mb-4">

<div class="col-lg-8">

<h2 class="fw-bold mb-1">

<i class="fa-solid fa-chalkboard-user text-primary"></i>

Data Guru

</h2>

<p class="text-muted">

Kelola seluruh data guru yang terdaftar pada sistem.

</p>

</div>

<div class="col-lg-4 text-end">

<a href="tambah_guru.php"

class="btn btn-primary btn-lg rounded-pill px-4">

<i class="fa fa-plus"></i>

Tambah Guru

</a>

</div>

</div> <div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div class="row align-items-end g-3">

            <div class="col-lg-6">

                <label class="form-label fw-semibold">

                    Pencarian Guru

                </label>

                <form method="GET">

                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="fa fa-search text-primary"></i>

                        </span>

                        <input
                            type="text"
                            name="cari"
                            class="form-control"
                            placeholder="Cari Nama Guru atau NIP..."
                            value="<?= $cari ?>">

                    </div>


            </div>

            <div class="col-lg-2 d-grid">

                <a href="guru.php"

                   class="btn btn-secondary">

                    <i class="fa fa-rotate"></i>

                    Refresh

                </a>

            </div>

            <div class="col-lg-2 text-end">

                <span class="badge bg-primary px-3 py-2 fs-6">

                    <?= $total ?> Guru

                </span>

            </div>

        </div>

        </form>

        <hr class="my-4"> <div class="table-responsive">

<table
id="guruTable"
class="table table-hover align-middle">

<thead>

<tr>

<th width="70">No</th>

<th>NIP</th>

<th>Nama Guru</th>

<th width="80">JK</th>

<th>No HP</th>

<th>Alamat</th>

<th width="150" class="text-center">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

if($total>0){

$no=1;

while($d=mysqli_fetch_assoc($query)){

?>

<tr>

<td>

<?= $no++ ?>

</td>

<td>

<?= $d['nip']; ?>

</td>

<td>

<div class="fw-semibold">

<?= $d['nama_guru']; ?>

</div>

</td>

<td class="text-center">

<?php

if($d['jk']=="L"){

echo "<span class='badge bg-primary'>L</span>";

}else{

echo "<span class='badge bg-danger'>P</span>";

}

?>

</td>

<td>

<?= $d['no_hp']; ?>

</td>

<td>

<?= $d['alamat']; ?>

</td>

<td class="text-center">

<div class="btn-group">

<a href="edit_guru.php?id=<?= $d['id_guru']; ?>" class="btn btn-warning btn-sm">
<i class="fa fa-pen"></i>
</a>

<a href="#"
class="btn btn-danger btn-sm"
onclick="konfirmasi('hapus_guru.php?id=<?= $d['id_guru']; ?>')">

<i class="fa fa-trash"></i>

</a>

</div>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7"

class="text-center text-muted py-5">

<i class="fa fa-folder-open fa-3x mb-3"></i>

<br>

Belum ada data guru.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<script>
$(document).ready(function () {

    $('#guruTable').DataTable({

        responsive:true,

        autoWidth:false,

        pageLength:10,

        language:{
            search:"Cari :",
            lengthMenu:"Tampilkan _MENU_ data",
            zeroRecords:"Data tidak ditemukan",
            info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty:"Tidak ada data",
            paginate:{
                first:"Awal",
                last:"Akhir",
                next:"»",
                previous:"«"
            }
        }

    });

});
</script>

<?php include "../layout/footer.php"; ?>