<?php
function admin(){
    session_start();
    koneksi();
    if ($_SESSION['level']== ""){
        header("location:../../index.php?pesan=gagal");
        exit;
    }elseif($_SESSION['level']!=="admin"){
        header("location:../../index.php?pesan=salah");
        exit;
    }
}

function guru(){
    session_start();
    koneksi();
    if ($_SESSION['level']== ""){
        header("location:../../index.php?pesan=gagal");
        exit;
    }elseif($_SESSION['level']!=="guru"){
        header("location:../../index.php?pesan=salah");
        exit;
    }
}
?>