<?php

$page = basename($_SERVER['PHP_SELF']);

?>

<div class="sidebar">

    <div class="logo text-center py-4">

        <h3 class="fw-bold text-white">

            <i class="fa fa-qrcode"></i>

            Sistem Absensi

        </h3>

        <small class="text-light">

            Guru Panel

        </small>

    </div>

    <hr class="text-light">

    <a class="<?= $page=="index.php"?"active":"" ?>" href="index.php">

        <i class="fa fa-home me-2"></i>

        Dashboard

    </a>

    <a class="<?= $page=="jadwal.php"?"active":"" ?>" href="jadwal.php">

        <i class="fa fa-calendar-alt me-2"></i>

        Jadwal Mengajar

    </a>

    <a class="<?= $page=="scan.php"?"active":"" ?>" href="scan.php">

        <i class="fa fa-qrcode me-2"></i>

        Scan QR

    </a>

    <a class="<?= $page=="riwayat.php"?"active":"" ?>" href="riwayat.php">

        <i class="fa fa-history me-2"></i>

        Riwayat Absensi

    </a>

    <a class="<?= $page=="laporan.php"?"active":"" ?>" href="laporan.php">

        <i class="fa fa-file-pdf me-2"></i>

        Laporan

    </a>

    <a href="../logout.php">

        <i class="fa fa-sign-out-alt me-2"></i>

        Logout

    </a>

</div>