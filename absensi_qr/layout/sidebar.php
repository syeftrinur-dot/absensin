<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">

    <!-- =========================
         HEADER SIDEBAR
    ========================== -->
    <div class="sidebar-header">
        <div class="avatar">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <h4>Admin</h4>
        <p>MTS Almunawaroh</p>
    </div>

    <!-- =========================
         MENU
    ========================== -->
    <div class="sidebar-menu">
        <div class="menu-title">MENU UTAMA</div>

        <a href="index.php" class="<?= ($current == 'index.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-gauge-high"></i>
            Dashboard
        </a>

        <a href="guru.php" class="<?= ($current == 'guru.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-chalkboard-user"></i>
            Data Guru
        </a>

        <a href="siswa.php" class="<?= ($current == 'siswa.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-user-graduate"></i>
            Data Siswa
        </a>

        <a href="kelas.php" class="<?= ($current == 'kelas.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-school"></i>
            Data Kelas
        </a>

        <a href="mapel.php" class="<?= ($current == 'mapel.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-book-open"></i>
            Mata Pelajaran
        </a>

        <a href="jadwal.php" class="<?= ($current == 'jadwal.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-calendar-days"></i>
            Jadwal
        </a>

        <a href="laporan.php" class="<?= ($current == 'laporan.php') ? 'active' : ''; ?>">
            <i class="fa-solid fa-file-lines"></i>
            Laporan
        </a>
    </div>

    <!-- ===========================
         LOGOUT
    ============================ -->
    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</div>