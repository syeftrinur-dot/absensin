<?php
session_start();

if(isset($_SESSION['login'])){

    if($_SESSION['role']=="admin"){

        header("Location: admin/index.php");

    }else{

        header("Location: guru/index.php");

    }

}else{

    header("Location: login.php");

}

exit;