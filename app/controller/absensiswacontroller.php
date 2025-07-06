<?php
namespace app\controller;
use app\model\absensiswa;
use app\model\siswa;

class absensiswacontroller{
    private $db;
    private $db2;

    public function __construct(){
        $this->db = new absensiswa();
        $this->db2 = new siswa();
    }

    public function api_proses_absen($nis,$ket){
        $model = $this->db;
        $tgl = date('Y-m-d');
        $cek = $model->cekkehadiransiswa($nis,$tgl);
        
        foreach ($cek as $row) {
            $result = $row['count'];
        };
        if ($result > 0) {
            $data = "Siswa sudah melakukan Presensi hari ini";
            header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        };

        $ambildatasiswa = $this->db2->pilihsiswa($nis);
        foreach ($ambildatasiswa as $s) {
            $nama = $s['nama'];
        };
        try{
            $data =[ 
                'id_absen' => idBaru('ABS','id_absen','absen'),
                'nis' => $nis,
                'nama' => $nama,
                'tgl' => date('Y-m-d'),
                'ket' => $ket
            ];
            $model->masukanabsensiswa($data);
            $data = "Peserta berhasil diabsen";
            header('Content-Type: application/json');
            echo json_encode($data);
        }catch( \Throwable $e){
            header('Content-Type: application/json');
                echo json_encode([
                    'Terjadi kesalahan dikontroller: ' . $e->getMessage()
                ]);
                exit;
        }
    }

    public function api_siswa_belumabsen($id_staff){
        $id_s = findById('staff','id_staff',$id_staff);
        $id_kelas = $id_s['id_kelas'];
        $siswa = $this->db->siswabelumabsen($id_kelas);
        header('Content-Type: application/json');
        echo json_encode($siswa);
        exit;
    }
}