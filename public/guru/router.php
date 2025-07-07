<?php
require_once __DIR__ . '/../../autoloader.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use app\controller\daftar_siswagurucontroller;
use app\controller\RouteController;

$controller = new RouteController();
    
$page = $_GET['page'] ?? 'homeguru';
$act = $_GET['act'] ?? null;

switch ($page) {
    case 'homeguru':
                $controller->homeguru(); // akan load view/default
    break;
    case 'presensi_guru':
                $controller->presensi_guru();
    break;
    case 'daftar_siswa':
        if      ($act === 'naik' && isset($_GET['nis'])){
                (new daftar_siswagurucontroller())->naik($_GET['nis']);
                break;
        }else{
                $controller->daftarsiswaguru();
        }
        break;
        case    'profil_guru':
                $controller->profil();
        break;
}
?>