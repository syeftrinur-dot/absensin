<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">

    <div class="sidebar-header">
        <div class="avatar">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <h4><?= htmlspecialchars($_SESSION['nama']); ?></h4>
        <p>Panel Guru</p>
    </div>

    <div class="sidebar-menu">
        <div class="menu-title">Menu Guru</div>

        <a href="index.php" class="<?= ($current == "index.php") ? "active" : ""; ?>">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="jadwal.php" class="<?= ($current == "jadwal.php") ? "active" : ""; ?>">
            <i class="fa-solid fa-calendar-days"></i>
            Jadwal Mengajar
        </a>

        <a href="scan.php" class="<?= ($current == "scan.php") ? "active" : ""; ?>">
            <i class="fa-solid fa-qrcode"></i>
            Scan QR
        </a>

        <a href="riwayat.php" class="<?= ($current == "riwayat.php") ? "active" : ""; ?>">
            <i class="fa-solid fa-clock-rotate-left"></i>
            Riwayat Absensi
        </a>

        <a href="laporan.php" class="<?= ($current == "laporan.php") ? "active" : ""; ?>">
            <i class="fa-solid fa-file-lines"></i>
            Laporan
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</div>
