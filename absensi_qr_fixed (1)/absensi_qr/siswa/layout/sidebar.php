<?php
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">

    <div class="sidebar-header">
        <div class="avatar">
            <i class="fa-solid fa-user-graduate"></i>
        </div>
        <h4><?= htmlspecialchars($_SESSION['nama']); ?></h4>
        <p>Panel Siswa</p>
    </div>

    <div class="sidebar-menu">
        <div class="menu-title">Menu Utama</div>

        <a href="index.php" class="<?= ($current == "index.php") ? 'active' : ''; ?>">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>

        <a href="riwayat.php" class="<?= ($current == "riwayat.php") ? 'active' : ''; ?>">
            <i class="fa-solid fa-clock-rotate-left"></i>
            Riwayat Absensi
        </a>

        <a href="profil.php" class="<?= ($current == "profil.php") ? 'active' : ''; ?>">
            <i class="fa-solid fa-id-card"></i>
            Profil Saya
        </a>

        <a href="ganti_pasword.php" class="<?= ($current == "ganti_pasword.php") ? 'active' : ''; ?>">
            <i class="fa-solid fa-key"></i>
            Ganti Password
        </a>
    </div>

    <div class="sidebar-footer">
        <a href="../logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</div>
