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
            $no_rumah = $s['no_rumah'];
            $id_kelas = $s['id_kelas'];
        };

        if ($ket == 'A'){
        // Ambil data wali kelas berdasarkan id_kelas
        $ambildatawalikelas = findById('staff','id_kelas',$id_kelas);
        if (!$ambildatawalikelas) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Data wali kelas tidak ditemukan']);
            exit;
        }

        $nama_walikelas = $ambildatawalikelas['nama'] ?? '-';
        $no_wa_walikelas = formatnowa($ambildatawalikelas['no'] ?? '');
        $no_walimurid = formatnowa($no_rumah);

        $pesan = "Assalamualaikum, Yth. Bapak/Ibu Wali Murid, \n\n Saudara $nama tidak hadir (A) pada tanggal $tgl. Mohon untuk menghubungi wali kelas $nama_walikelas di nomor $no_wa_walikelas.\n\nTerima kasih."
        ."ℹ️ Dimohon untuk tidak membalas pesan ini, karena ini adalah pesan otomatis dari sistem presensi sekolah.";

        // Kirim WA pakai Fonnte
        $token = "vXze72HNXjgiDio2Z9HK";

        function Kirimfonnte($token, $data) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'target' => $data["target"],
                    'message' => $data["message"],
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array('Authorization: ' . $token),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // bisa ditambahkan log $response kalau perlu
        }

        $pesan1 = ["target" => $no_walimurid, "message" => $pesan];
        Kirimfonnte($token, $pesan1);
    }


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