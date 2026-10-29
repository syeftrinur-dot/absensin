<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "koneksi.php";

$error = "";

/* =====================================
   JIKA SUDAH LOGIN
===================================== */

if(isset($_SESSION['login'])){

    switch($_SESSION['role']){

        case "admin":
            header("Location: admin/index.php");
            exit;

        case "guru":
            header("Location: guru/index.php");
            exit;

        case "siswa":
            header("Location: siswa/index.php");
            exit;

    }

}

/* =====================================
   PROSES LOGIN
===================================== */

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username = isset($_POST['username'])
        ? trim($_POST['username'])
        : "";

    $password = isset($_POST['password'])
        ? trim($_POST['password'])
        : "";

    if($username=="" || $password==""){

        $error = "Username dan Password wajib diisi.";

    }else{

        $sql = mysqli_query($koneksi,"
            SELECT *
            FROM users
            WHERE username='$username'
            AND password='$password'
            LIMIT 1
        ");

        if(mysqli_num_rows($sql)==1){

            $user = mysqli_fetch_assoc($sql);

            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
           /* ============================
              LOGIN ADMIN
            ============================ */

            if($user['role']=="admin"){

                header("Location: admin/index.php");
                exit;

            }

            /* ============================
               LOGIN GURU
            ============================ */

            elseif($user['role']=="guru"){

                $_SESSION['id_guru'] = $user['id_guru'];

                header("Location: guru/index.php");
                exit;

            }

            /* ============================
               LOGIN SISWA
            ============================ */

            elseif($user['role']=="siswa"){

                $_SESSION['id_siswa'] = $user['id_siswa'];

                header("Location: siswa/index.php");
                exit;

            }

            /* ============================
               ROLE TIDAK VALID
            ============================ */

            else{

                session_destroy();

                $error = "Role tidak dikenali.";

            }

        }else{

            $error = "Username atau Password salah.";

        }

    }

}

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Sistem Absensi QR</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<style>
    
/* =====================================================
   RESET
===================================================== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    background:linear-gradient(135deg,#2563eb,#1d4ed8,#0f172a);
}

/* =====================================================
   CONTAINER
===================================================== */

.login-container{
    width:1100px;
    height:650px;
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    border-radius:25px;
    overflow:hidden;
    display:flex;
    box-shadow:0 20px 60px rgba(0,0,0,.30);
}

/* =====================================================
   PANEL KIRI
===================================================== */

.left-panel{
    width:50%;
    background:linear-gradient(180deg,#2563eb,#1d4ed8);
    color:#fff;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    padding:50px;
}

.logo-circle{
    width:100px;
    height:100px;
    border-radius:50%;
    background:#fff;
    color:#2563eb;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.20);
}

.left-panel h1{
    font-size:34px;
    font-weight:700;
    margin-bottom:12px;
}

.left-panel p{
    text-align:center;
    line-height:28px;
    opacity:.9;
    margin-bottom:30px;
}

.character{
    width:320px;
    animation:float 3s ease-in-out infinite;
}

.character img{
    width:100%;
}

/* =====================================================
   PANEL KANAN
===================================================== */

.right-panel{
    width:50%;
    background:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:45px;
}

.login-box{
    width:100%;
    max-width:420px;
}

.login-box h2{
    font-size:34px;
    font-weight:700;
    color:#111827;
}

.login-box p{
    color:#6b7280;
    margin-bottom:30px;
}

/* =====================================================
   FORM
===================================================== */

label{
    font-weight:600;
    margin-bottom:8px;
    display:block;
}

.input-group{
    margin-bottom:20px;
}

.input-group-text{
    background:#f8fafc;
    border-right:none;
}

.form-control{
    height:52px;
    border-left:none;
}

.form-control:focus{
    box-shadow:none;
    border-color:#2563eb;
}

.btn-login{
    height:52px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:12px;
    font-weight:700;
    transition:.3s;
}

.btn-login:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

/* =====================================================
   ALERT
===================================================== */

.alert{
    border-radius:12px;
    border:none;
}

/* =====================================================
   COPYRIGHT
===================================================== */

.copyright{
    margin-top:25px;
    text-align:center;
    color:#9ca3af;
    font-size:13px;
}

/* =====================================================
   ANIMATION
===================================================== */

@keyframes float{

    0%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-12px);
    }

    100%{
        transform:translateY(0);
    }

}

/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:992px){

    .login-container{
        width:95%;
        height:auto;
        flex-direction:column;
    }

    .left-panel,
    .right-panel{
        width:100%;
    }

    .left-panel{
        padding:40px;
    }

    .right-panel{
        padding:35px;
    }

}

@media(max-width:576px){

    .left-panel{
        display:none;
    }

    .right-panel{
        width:100%;
    }

}
</style>

</head>

<body>

<div class="login-container">

    <!-- ===========================
         PANEL KIRI
    ============================ -->

    <div class="left-panel">

        <div class="logo-circle" id="logo">

            <i class="fa-solid fa-qrcode"></i>

        </div>

        <h1 id="title">

            Sistem Absensi QR

        </h1>

        <p id="subtitle">

            Aplikasi Absensi Guru dan Siswa
            berbasis QR Code.

        </p>

        <div class="character" id="character">

            <?php if(file_exists("assets/img/login-illustration.png")){ ?>

                <img
                src="assets/img/login-illustration.png"
                alt="Login Illustration">

            <?php }else{ ?>

                <i
                class="fa-solid fa-user-shield"
                style="font-size:180px;color:white;"></i>

            <?php } ?>

        </div>

    </div>

    <!-- ===========================
         PANEL KANAN
    ============================ -->

    <div class="right-panel">

        <div class="login-box" id="loginBox">

            <h2>

                Selamat Datang 👋

            </h2>

            <p>

                Silakan login menggunakan akun Anda.

            </p>

            <?php if($error!=""){ ?>

                <div class="alert alert-danger">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <?= $error ?>

                </div>

            <?php } ?>

            <form method="POST" id="loginForm">

                <div class="mb-3">

                    <label>

                        Username

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-user"></i>

                        </span>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Masukkan Username"
                            required
                            autofocus>

                    </div>

                </div>

                <div class="mb-4">

                    <label>

                        Password

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-lock"></i>

                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan Password"
                            required>

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()">

                            <i
                                id="eye"
                                class="fa-solid fa-eye"></i>

                        </button>

                    </div>

                </div>

                <div class="d-grid">

                    <button
                        id="btnLogin"
                        type="submit"
                        class="btn btn-login">

                        <i class="fa-solid fa-right-to-bracket"></i>

                        LOGIN

                    </button>

                </div>

            </form>

            <div class="copyright">

                © <?= date('Y'); ?>

                Sistem Absensi QR Code

            </div>

        </div>

    </div>

</div>
<script>

/* ===========================================
   SHOW / HIDE PASSWORD
=========================================== */

function togglePassword(){

    let password = document.getElementById("password");

    let eye = document.getElementById("eye");

    if(password.type === "password"){

        password.type = "text";

        eye.classList.remove("fa-eye");

        eye.classList.add("fa-eye-slash");

    }else{

        password.type = "password";

        eye.classList.remove("fa-eye-slash");

        eye.classList.add("fa-eye");

    }

}

/* ===========================================
   LOADING LOGIN BUTTON
=========================================== */

document.getElementById("loginForm").addEventListener("submit",function(){

    let btn=document.getElementById("btnLogin");

    btn.disabled=true;

    btn.innerHTML='<i class="fa fa-spinner fa-spin"></i> Memproses...';

});

/* ===========================================
   GSAP ANIMATION
=========================================== */

gsap.from("#logo",{

    duration:1,

    y:-80,

    opacity:0,

    ease:"back.out(1.7)"

});

gsap.from("#title",{

    duration:1,

    delay:.3,

    x:-80,

    opacity:0

});

gsap.from("#subtitle",{

    duration:1,

    delay:.6,

    x:-80,

    opacity:0

});

gsap.from("#character",{

    duration:1.2,

    delay:.9,

    y:80,

    opacity:0

});

gsap.from("#loginBox",{

    duration:1,

    delay:.5,

    x:80,

    opacity:0

});

/* ===========================================
   FOCUS EFFECT
=========================================== */

$(".form-control").focus(function(){

    $(this).parent().css({

        transform:"scale(1.02)",

        transition:".25s"

    });

});

$(".form-control").blur(function(){

    $(this).parent().css({

        transform:"scale(1)"

    });

});

</script>

</body>

</html>