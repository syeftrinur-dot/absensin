<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set("Asia/Jakarta");

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sistem Absensi QR</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>

/*====================================
ROOT
=====================================*/
:root{
    --primary:#2563eb;
    --primary-dark:#1d4ed8;
    --success:#16a34a;
    --danger:#dc2626;
    --warning:#f59e0b;
    --info:#0ea5e9;
    --white:#ffffff;
    --text:#1f2937;
    --border:#e5e7eb;
    --background:#f4f7fb;
    --radius:18px;
    --shadow:0 12px 30px rgba(0,0,0,.08);
}

/*====================================
RESET
=====================================*/
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
html{
    scroll-behavior:smooth;
}
html, body{
    overflow-x:hidden;
}
body{
    font-family:'Poppins',sans-serif;
    background:var(--background);
    color:var(--text);
}
a{
    text-decoration:none;
}
img{
    max-width:100%;
    height:auto;
}
button{
    border:none;
    outline:none;
}
.container,
.container-fluid{
    width:100%;
}

/*====================================
NAVBAR
=====================================*/
.navbar{
    position:fixed;
    top:0;
    left:0;
    right:0;
    height:70px;
    background:#fff;
    display:flex;
    align-items:center;
    box-shadow:var(--shadow);
    padding:0 20px;
    z-index:1050;
}
.navbar-brand{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:30px;
    font-weight:700;
    color:var(--primary)!important;
    white-space:nowrap;
}
.navbar-brand i{
    font-size:28px;
}
.navbar-right{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:15px;
}
.navbar .dropdown-toggle{
    font-weight:600;
    color:#374151!important;
}
.dropdown-menu{
    border:none;
    border-radius:14px;
    box-shadow:var(--shadow);
    padding:10px;
}
.dropdown-item{
    padding:10px 15px;
    border-radius:10px;
    transition:.3s;
}
.dropdown-item:hover{
    background:#eef4ff;
}

/*====================================
MOBILE TOGGLE BUTTON
=====================================*/
.mobile-toggle{
    display:none;
    width:45px;
    height:45px;
    border:none;
    border-radius:10px;
    background:#2563eb;
    color:#fff;
    font-size:20px;
    cursor:pointer;
    margin-right:15px;
}

/*====================================
CONTENT
=====================================*/
.content{
    margin-top:90px;
    margin-left:260px;
    padding:25px;
    width:calc(100% - 260px);
    transition:.35s ease;
    min-height:100vh;
}

/*====================================
SIDEBAR
=====================================*/
.sidebar{
    position:fixed;
    top:70px;
    left:0;
    width:260px;
    height:calc(100vh - 70px);
    background:linear-gradient(180deg,#2563eb,#1d4ed8);
    display:flex;
    flex-direction:column;
    overflow:hidden;
    box-shadow:5px 0 20px rgba(0,0,0,.08);
    z-index:999;
    transition:.35s ease;
}

/*====================================
HEADER SIDEBAR
=====================================*/
.sidebar-header{
    padding:30px 20px;
    text-align:center;
    border-bottom:1px solid rgba(255,255,255,.15);
}
.avatar{
    width:90px;
    height:90px;
    margin:auto;
    background:#fff;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:38px;
    color:#2563eb;
    margin-bottom:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.20);
}
.sidebar-header h4{
    color:#fff;
    font-size:22px;
    font-weight:700;
    margin-bottom:5px;
}
.sidebar-header p{
    color:rgba(255,255,255,.80);
    font-size:14px;
    margin:0;
}

/*====================================
MENU
=====================================*/
.sidebar-menu{
    flex:1;
    padding:18px 12px;
    overflow-y:auto;
}
.sidebar-menu::-webkit-scrollbar{
    width:6px;
}
.sidebar-menu::-webkit-scrollbar-thumb{
    background:rgba(255,255,255,.30);
    border-radius:20px;
}
.menu-title{
    font-size:12px;
    font-weight:700;
    letter-spacing:1px;
    padding:0 10px 15px;
    color:rgba(255,255,255,.65);
    text-transform:uppercase;
}
.sidebar-menu a{
    display:flex;
    align-items:center;
    gap:14px;
    padding:14px 18px;
    margin-bottom:8px;
    border-radius:14px;
    color:#fff;
    text-decoration:none;
    font-weight:600;
    transition:.25s;
}
.sidebar-menu a i{
    width:22px;
    font-size:17px;
    text-align:center;
}
.sidebar-menu a:hover{
    background:rgba(255,255,255,.12);
    padding-left:24px;
}
.sidebar-menu a.active{
    background:#fff;
    color:#2563eb;
    box-shadow:0 8px 20px rgba(0,0,0,.12);
}

/*====================================
FOOTER SIDEBAR
=====================================*/
.sidebar-footer{
    padding:18px;
    border-top:1px solid rgba(255,255,255,.15);
}
.logout-btn{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    padding:13px;
    border-radius:14px;
    background:#ef4444;
    color:#fff;
    font-weight:700;
    text-decoration:none;
    transition:.25s;
}
.logout-btn:hover{
    background:#dc2626;
    color:#fff;
    transform:translateY(-2px);
}

/*====================================
SIDEBAR OVERLAY (MOBILE)
=====================================*/
.sidebar-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.45);
    z-index:998;
}
.sidebar-overlay.show{
    display:block;
}

/*====================================
CARD
=====================================*/
.card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    overflow:hidden;
    background:#fff;
}
.card-header{
    background:#fff;
    border-bottom:none;
    padding:20px 25px;
    font-size:18px;
    font-weight:700;
    color:#1f2937;
}
.card-body{
    padding:25px;
}

/*====================================
DASHBOARD CARD
=====================================*/
.dashboard-card{
    border-radius:20px;
    padding:22px;
    color:#fff;
    position:relative;
    overflow:hidden;
    transition:.3s;
}
.dashboard-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 40px rgba(0,0,0,.15);
}
.dashboard-card.primary{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
}
.dashboard-card.success{
    background:linear-gradient(135deg,#16a34a,#15803d);
}
.dashboard-card.warning{
    background:linear-gradient(135deg,#f59e0b,#d97706);
}
.dashboard-card.danger{
    background:linear-gradient(135deg,#dc2626,#b91c1c);
}
.dashboard-card.info{
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
}
.dashboard-card.secondary{
    background:linear-gradient(135deg,#64748b,#475569);
}
.dashboard-title{
    font-size:14px;
    opacity:.9;
    margin-bottom:8px;
}
.dashboard-number{
    font-size:34px;
    font-weight:700;
}
.dashboard-icon{
    position:absolute;
    right:20px;
    top:18px;
    font-size:50px;
    opacity:.15;
}

/*====================================
FORM
=====================================*/
.form-label{
    font-weight:600;
    margin-bottom:8px;
    color:#374151;
}
.form-control,
.form-select{
    height:48px;
    border-radius:12px;
    border:1px solid #d1d5db;
    padding:10px 14px;
}
.form-control:focus,
.form-select:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 .2rem rgba(37,99,235,.15);
}
textarea.form-control{
    height:auto;
}
.input-group-text{
    background:#fff;
    border-right:none;
}
.input-group .form-control{
    border-left:none;
}

/*====================================
BUTTON
=====================================*/
.btn{
    border-radius:12px;
    font-weight:600;
    padding:10px 18px;
    transition:.25s;
}
.btn:hover{
    transform:translateY(-2px);
}
.btn-sm{
    padding:7px 14px;
    font-size:13px;
}

/*====================================
TABLE
=====================================*/
.table{
    margin-bottom:0;
}
.table-responsive{
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
.table thead{
    background:#2563eb;
    color:#fff;
}
.table thead th{
    border:none;
    padding:15px;
    font-weight:600;
    vertical-align:middle;
}
.table tbody td{
    padding:14px;
    vertical-align:middle;
}
.table tbody tr{
    transition:.25s;
}
.table tbody tr:hover{
    background:#f8fbff;
}
.table .btn{
    min-width:82px;
    margin:2px;
}

/*====================================
BADGE
=====================================*/
.badge{
    padding:8px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

/*====================================
PROGRESS
=====================================*/
.progress{
    height:10px;
    border-radius:30px;
    background:#e5e7eb;
    overflow:hidden;
}
.progress-bar{
    border-radius:30px;
}

/*====================================
DATATABLE
=====================================*/
.dataTables_wrapper .dataTables_filter input{
    border-radius:10px;
    border:1px solid #d1d5db;
    padding:6px 10px;
}
.dataTables_wrapper .dataTables_length select{
    border-radius:10px;
    border:1px solid #d1d5db;
    padding:5px 8px;
}
.dataTables_wrapper .paginate_button{
    border-radius:8px!important;
}
.dataTables_wrapper .dataTables_info{
    padding-top:15px;
    font-size:14px;
    color:#6b7280;
}

/*====================================
SCROLLBAR
=====================================*/
::-webkit-scrollbar{
    width:8px;
    height:8px;
}
::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:20px;
}
::-webkit-scrollbar-track{
    background:#f1f5f9;
}

/*====================================
RESPONSIVE
=====================================*/

/* Tablet & di bawahnya: sidebar jadi drawer, tombol toggle muncul */
@media (max-width:992px){
    .sidebar{
        left:-260px;
    }
    .sidebar.show{
        left:0;
    }
    .content{
        margin-left:0;
        width:100%;
        margin-top:90px;
        padding:20px;
    }
    .mobile-toggle{
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .navbar{
        padding:0 15px;
    }
    .navbar-brand{
        font-size:22px;
    }
}

/* HP (tablet kecil / ponsel besar) */
@media (max-width:768px){
    body{
        font-size:14px;
    }
    h1{ font-size:24px; }
    h2{ font-size:22px; }
    h3{ font-size:20px; }

    .content{
        padding:15px;
    }
    .card{
        margin-bottom:15px;
    }
    .card-body{
        padding:18px;
    }
    .table{
        font-size:14px;
    }
    .btn{
        padding:8px 14px;
    }
    .container,
    .container-fluid{
        padding-left:15px;
        padding-right:15px;
    }
}

/* HP kecil */
@media (max-width:576px){
    .navbar{
        height:65px;
    }
    .navbar-brand{
        font-size:18px;
    }
    .navbar-brand i{
        font-size:20px;
    }
}

</style>

</head>

<body>

<!-- ===============================
     NAVBAR
================================ -->
<nav class="navbar navbar-expand-lg">
<div class="container-fluid">

    <button class="mobile-toggle" id="mobileToggle">
        <i class="fa-solid fa-bars"></i>
    </button>

    <a class="navbar-brand" href="index.php">
        <i class="fa-solid fa-qrcode"></i>
        Sistem Absensi QR
    </a>

    <div class="navbar-right">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user-circle"></i>
                    <?= htmlspecialchars($_SESSION['nama']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <h6 class="dropdown-header"><?= htmlspecialchars($_SESSION['nama']); ?></h6>
                    </li>
                    <li>
                        <span class="dropdown-item-text text-muted">
                            Role : <?= htmlspecialchars($_SESSION['role']); ?>
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="../logout.php">
                            <i class="fa-solid fa-right-from-bracket me-2 text-danger"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</div>
</nav>

<div id="sidebarOverlay" class="sidebar-overlay"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("mobileToggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (menuBtn && sidebar && overlay) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
        });

        overlay.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.classList.remove("show");
        });

        // Tutup sidebar otomatis saat menu diklik di tampilan HP/tablet
        sidebar.querySelectorAll(".sidebar-menu a").forEach(function (link) {
            link.addEventListener("click", function () {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove("show");
                    overlay.classList.remove("show");
                }
            });
        });
    }
});
</script>