<?php

namespace app\controller;
use app\model\staff;
ini_set('display_errors', 1);
error_reporting(E_ALL);
// pengatur viewloader/view controller
class RouteController{
    public function __construct(){
    }
    public function dashboard(){
         include __DIR__."/../view/dashboard/index.php";
    }

    public function staff(){
        include __DIR__."/../view/staff/index.php";
    }
    
    public function tambahstaff(){
        include __DIR__."/../view/staff/tambah_staff.php";

    }
    public function editstaff($id_staff){
        include __DIR__."/../view/staff/edit_staff.php";
    }
    public function hapusstaff($id_staff){
        include __DIR__."/../view/staff/hapus_staff.php";
    }

    public function wawancara(){        
        include __DIR__."/../view/wawancara/index.php";
    }

    public function tambahwawancara(){
        include __DIR__."/../view/wawancara/tambah_wawancara.php";
    }
    public function editwawancara($id_jobs){
        include __DIR__."/../view/wawancara/edit_wawancara.php";
    }
    public function hapuswawancara($id_jobs){
        include __DIR__."/../view/wawancara/hapus_wawancara.php";
    }
    public function tambahpeserta($id_jobs){
        include __DIR__."/../view/wawancara/tambah_peserta.php";
    }
    public function pesertalolos($id_w){
        include __DIR__."/../view/wawancara/peserta_lolos.php";
    }
    public function siswa(){        
        include __DIR__."/../view/siswa/index.php";
    }
    
    public function detailsiswa($nis){
        include __DIR__."/../view/siswa/detail.php";
    }
    public function editsiswa($nis){
        include __DIR__."/../view/siswa/edit.php";
    }
    public function tambah_job($nis){
        include __DIR__."/../view/siswa/tambah_job.php";
    }
    public function uploaddoc($nis){
        include __DIR__."/../view/siswa/upload_doc.php";
    }
    
    public function lolos(){
        include __DIR__."/../view/lolos/index.php";
    }
    public function detaillolos($nis){
        include __DIR__."/../view/lolos/detail.php";
    }
    public function editlolos($nis){
        include __DIR__."/../view/lolos/edit.php";
    }
    public function addtagihan($nis){
        include __DIR__."/../view/lolos/tagihan.php";
    }
    public function bayartagihan($tagihan){
        include __DIR__."/../view/lolos/bayar.php";
    }

    public function kelas(){
        include __DIR__."/../view/kelas/index.php";
    }

    public function tambahkelas(){
        include __DIR__."/../view/kelas/tambah.php";
    }

    public function editkelas($id_kelas){
        include __DIR__."/../view/kelas/edit.php";
    }

    public function presensi(){
        include __DIR__."/../view/presensi/index.php";
    }

    public function so(){
        include __DIR__."/../view/so/index.php";  
    }
    public function tambahso(){
        include __DIR__."/../view/so/tambah_so.php";  
    }
    public function homeguru(){
        include __DIR__."/../view/guru/index.php";  
    }
    public function presensi_guru(){
        include __DIR__."/../view/guru/presensi_guru.php";  
    }
    public function daftarsiswaguru(){
        include __DIR__."/../view/guru/daftar_siswa.php";  
    }
    public function profil(){
        include __DIR__."/../view/guru/profil.php";  
    }

    public function laporan_guru(){
        include __DIR__."/../view/guru/laporan_guru.php"; 
    }
    public function finance(){
        include __DIR__."/../view/finance/index.php";  
    }
}