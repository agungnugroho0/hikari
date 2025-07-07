<?php
namespace app\controller;
use app\model\siswa;
use app\model\guru;
use app\model\kelas;

class daftar_siswagurucontroller{
    private $db;
    private $db2;
    private $db3;
    public function __construct(){
        $this->db = new guru();
        
    }
    public function ukk($id_kelas){
       $hari_ini = date('Y-m-d');
        $event = $this->db->kenaikankelas();
        $tgl_event =  isset($event[0]['tgl_event']) ? substr($event[0]['tgl_event'], 0, 10) : null;

        if ( $tgl_event !== null && $hari_ini == $tgl_event && $id_kelas !== '1') {
            return true;
        } else {
            return false;
        }
    }

    public function naik($nis){
        $this->db2 = new Siswa();
        $this->db3 = new Kelas();
        $siswa = $this->db2->detail($nis,'siswa');
        foreach ($siswa as $s) {
            $id_kelas = $s['id_kelas'];
        };

        $tingkatan = $this->db3->pilihkelas($id_kelas);
        foreach($tingkatan as $t){
            $tingkat = $t['tingkat'];
        };
        $tingkatbaru = $tingkat - 1 ;
        $tingkatan2 = $this->db3->pilihkelas($tingkatbaru);
        foreach($tingkatan2 as $t2){
                    $id_kelasbaru = $t2['id_kelas'];
        };
        try{
            $data=[
                'nis' => $nis,
                'id_kelas' => $id_kelasbaru
            ];
            $this->db->naik($data);
         header('Content-Type: application/json');
                            echo json_encode([
                                'success' => true,
                                'message' => 'Siswa sudah dinaikkan'
                            ]);
                            exit;
        }catch( \Throwable $e){
            header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan dikontroller: ' . $e->getMessage()
                ]);
                exit;
        }   
        
    }
}