<?php
namespace app\middleware;
session_start();
class AuthMiddleware{
    public static function checklogin(){
        if (!isset($_SESSION['username'])) {
            header("Location: ../../index.php?pesan=gagal");
            exit;
        }
    }

    public static function checkRole($role)
    {
        if (!isset($_SESSION['level']) || $_SESSION['level'] !== $role) {
            header("Location: ../../index.php?pesan=sesi telah berakhir");
            exit;
        }
    }
}