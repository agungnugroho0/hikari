<?php
require_once __DIR__ . '/../../autoloader.php';
require_once __DIR__ . '/../../vendor/autoload.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
// digunakan untuk mengatur semua lalu lintas web
use app\controller\RouteController;
use app\controller\staffcontroller;
use app\controller\wawancaracontroller;
use app\controller\siswacontroller;
use app\controller\loloscontroller;
use app\controller\kelascontroller;
use app\controller\socontroller;


$controller = new RouteController();
    
$page = $_GET['page'] ?? 'home';
$act = $_GET['act'] ?? null;

switch ($page) {
    case 'home':
        if ($act === 'finance'){
                $controller->finance();
        }else{
                $controller->dashboard();// akan load view/dashboard/index.php
        }
        
        break;
    case 'staff':
        if      ($act === 'tambah'){
            $controller->tambahstaff();
        }elseif ($act ==='edit' && isset($_GET['id_staff'])){
            $controller->editstaff($_GET['id_staff']);
        }elseif ($act === 'hapus' && isset($_GET['id_staff'])) {
            $controller->hapusstaff($_GET['id_staff']);
        }elseif ($act ==='simpan' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            (new staffcontroller())->simpan();
        }elseif ($act ==='update' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            (new staffcontroller())->update($_POST,$_FILES);
        }elseif ($act === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST'){
            (new staffcontroller())->hapus($_POST['id_staff']);
        }else{
            $controller->staff();
        }
        break;
    case 'wawancara':
        if      ($act ==='tambah'){
                $controller->tambahwawancara();
        }elseif ($act ==='insert' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new wawancaracontroller())->tambahwawancara();
        }elseif ($act ==='edit'  && isset($_GET['id_jobs'])){
                $controller->editwawancara($_GET['id_jobs']);
        }elseif ($act === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new wawancaracontroller())->updatewawancara($_POST);
        }elseif ($act ==='hapus'  && isset($_GET['id_jobs'])){
                $controller->hapuswawancara($_GET['id_jobs']);
        }elseif ($act === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new wawancaracontroller())->hapus($_POST['id_job']);
        }elseif ($act ==='tambahpeserta'  && isset($_GET['id_jobs'])){
                $controller->tambahpeserta($_GET['id_jobs']);
        }elseif ($act === 'tambah_peserta' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new wawancaracontroller())->tambahpeserta($_POST);
        }elseif ($act === 'lolos' && isset($_GET['id_w'])){
                $controller->pesertalolos($_GET['id_w']);
        }elseif ($act === 'simpan_lolos' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new wawancaracontroller())->simpanlolos($_POST);
        }elseif ($act === 'gagal' && isset($_GET['id_w'])){
                (new wawancaracontroller())->gagalpeserta($_GET['id_w']);
        }else{
                    $controller->wawancara();
        }
        break;
    case 'siswa':
        if      ( $act === 'detail' && isset($_GET['nis'])){
                $controller->detailsiswa($_GET['nis']);
        }elseif ($act === 'uploaddoc' && isset($_GET['nis'])){
                $controller->uploaddoc($_GET['nis']);
        }elseif ($act === 'downloadfile') {
                (new siswacontroller())->downloadfile($_GET);
        }elseif ($act === 'hapusdoc'){
                (new siswacontroller())->hapusdoc($_GET);
        } elseif ($act === 'upload_doc' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new siswacontroller())->uploaddokumen($_POST,$_FILES);
        }elseif ( $act === 'edit' && isset($_GET['nis'])){
                $controller->editsiswa($_GET['nis']);
        } elseif ($act === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new siswacontroller())->updatesiswa($_POST,$_FILES);
        } elseif ($act === 'hapus' && isset($_GET['nis'])) {
                (new siswacontroller())->hapussiswa($_GET['nis']);
        } elseif ($act === 'add_job' && isset($_GET['nis'])) {
                $controller->tambah_job($_GET['nis']);
        } elseif ($act === 'tambah_job' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new siswacontroller())->tambahjob($_POST);
        }else{
                $controller->siswa();
        }
        break;
case 'lolos':
        if      ($act === 'detail' && isset($_GET['nis'])){
                $controller->detaillolos($_GET['nis']);
        }elseif ( $act === 'edit' && isset($_GET['nis'])){
                $controller->editlolos($_GET['nis']);
        }elseif ( $act === 'addtagihan' && isset($_GET['nis'])){
                $controller->addtagihan($_GET['nis']);
        }elseif ( $act === 'bayartagihan' && isset($_GET['tagihan'])){
                $controller->bayartagihan($_GET['tagihan']);
        }elseif ( $act === 'kuitansi' && isset($_GET['id_tx'])){
                (new loloscontroller())-> cetakkuitansi($_GET['id_tx']);
        }elseif ($act === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new loloscontroller())->updatelolos($_POST,$_FILES);
        }elseif ($act === 'tagihan' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new loloscontroller())->buattagihan();
        }elseif ($act === 'transaksi' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                (new loloscontroller())->transaksi($_POST);
        }else{
                $controller->lolos();
        }
        break;
        case 'kelas':
        if      ($act === 'tambah'){
                $controller->tambahkelas();
                }elseif ($act ==='simpan' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new kelascontroller())->simpan($_POST);
                }elseif ($act ==='update' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new kelascontroller())->update($_POST);
                }elseif ( $act === 'edit' && isset($_GET['id_kelas'])){
                $controller->editkelas($_GET['id_kelas']);
                }elseif ( $act === 'hapus' && isset($_GET['id_kelas'])){
                (new kelascontroller())->hapuskelas($_GET['id_kelas']);

                } else {
                        $controller->kelas();
                }
        break;
        case 'presensi':
                $controller->presensi();        
        break;
        case 'so':
        if      ( $act ==='tambah'){
                $controller->tambahso();
        }elseif ($act ==='simpan' && $_SERVER['REQUEST_METHOD'] === 'POST'){
                (new socontroller())->simpanso();
        }else{
                $controller->so();
        }        
        break;
case 'finance':
                $controller->finance();
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
}
