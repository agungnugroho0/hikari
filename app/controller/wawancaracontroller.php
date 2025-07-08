<?php
namespace app\controller;
use app\model\wawancara;

class wawancaracontroller{

    private $db;

    public function  __construct(){
        $this->db = new wawancara();
    }

    public function tampilwawancara(){
        $wawancara = $this->db->tampilwawancara();
        // return $wawancara->tampilwawancara();
        return $wawancara;
    }

    public function daftarsiswa(){
        $siswa = $this->db->daftarsiswa();
        return $siswa;
    }
    public function formwawancara(){
        // return (new wawancara())->data_so();
        return $this->db->data_so();
    }

    public function tambahwawancara(){
        // $model = new wawancara();
        try{
            $id = idBaru('J','id_job','job');
            $id_so = $_POST['nama_so'];
            $job = $_POST['nama_job'];
            $perusahaan = $_POST['nama_perusahaan'];
            $interview = $_POST['interview'];
            $penempatan = $_POST['nama_penempatan'];
            $tgl_job = !empty($_POST['tgl_interview']) ? $_POST['tgl_interview'] : null;

            $data = [
                'id_job' => $id,
                'job' => $job,
                'perusahaan' => $perusahaan,
                'id_so'=> $id_so,
                'tgl_job' => $tgl_job,
                'interview' => $interview,
                'penempatan' => $penempatan
            ];
            $this->db->simpan($data);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Training Order berhasil ditambahkan!'
            ]);
            exit;
        }catch(\Exception $e){
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public function cariwawancara($id){
        return findById('job', 'id_job', $id);
        
    }

    public function lolossiswa($id_w){
        $log_lolos = $this->db->dataloglolos($id_w);
        return $log_lolos;
    }

    public function updatewawancara($POST){
        // $model = new wawancara();
        $data = [
            'id_job' => $POST['id_job'],
            'job' => $POST['nama_job'],
            'perusahaan' => $POST['nama_perusahaan'],
            'interview' => $POST['interview'],
            'penempatan' => $POST['nama_penempatan'],
            'tgl_job' => !empty($POST['tgl_interview']) ? $POST['tgl_interview'] : null
        ];

        $this->db->update($data);
        echo json_encode([
            'success' => true,
            'message' => 'Data TO berhasil diupdate!'
        ]);
        exit;
    }

    public function hapus($id_job){
        // $model = new wawancara();
        try {
            $this->db->hapus($id_job);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Data Training Order berhasil dihapus.'
            ]);
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public function tambahpeserta($POST){
        try{
            // $id_w = 
            $id = $POST['id_job'];
            $siswaList = $POST['siswa'] ?? [];
            foreach ($siswaList as $nis) {
                $this->db->tambahPeserta([
                    'id_w' => idBaru('W','id_w','wawancara'),
                    'id_job' => $id,
                    'nis' => $nis
                ]);
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Peserta berhasil ditambahkan.'
            ]);
            exit;
        }catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Peserta gagal ditambahkan.'
            ]);
            exit;
        }
    }

    public function simpanlolos($POST){
        try{
            $id_tagihan = idBaru('T','id_tagihan','tagihan');
            $prefix = substr($id_tagihan,0,-3);
            $angka = (int) substr($id_tagihan,-3);
            $angka_baru = $angka+1;
            $id_tagihan2 = $prefix . str_pad($angka_baru, 3, '0', STR_PAD_LEFT);
            $data=[
                'id_loglolos' => idBaru('LLS','id_loglolos','log_lolos'),
                
                'id_tagihan2' => $id_tagihan2,
                'nis' => $POST['nis'],
                'tgl_lolos' => $POST['tgl_lolos'],
                'so' => $POST['nama_so'],
                'job' => $POST['nama_job'],
                'perusahaan' => $POST['nama_perusahaan'],
            ];

            $tagihanList=[
                [
                    'id_tagihan' => $id_tagihan,
                    'jenis_tagihan' => $POST['tagihan_hikari'],
                    'biaya_tagihan' => str_replace('.','',$POST['biaya_hikari']),
                    'nis' => $POST['nis'],
                    'status_tagihan' => 'belum lunas',
                    'sisa_tagihan' => str_replace('.','',$POST['biaya_hikari'])
                ],
                [
                    'id_tagihan' => $id_tagihan2,
                    'jenis_tagihan' => $POST['tagihan_so2'],
                    'biaya_tagihan' => str_replace('.','',$POST['tagihan_so']),
                    'nis' => $POST['nis'],
                    'status_tagihan' => 'belum lunas',
                    'sisa_tagihan' =>str_replace('.','',$POST['tagihan_so'])
                ]
            ];



            $token = "vXze72HNXjgiDio2Z9HK";
            function Kirimfonnte($token, $data)
            {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $data["target"],
                        'message' => $data["message"],
                        'countryCode' => '62', //optional
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: ' . $token
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response; //log response fonnte
            };

            $data_siswa = $this->db->datasiswa($POST['nis']);
            $no_wa = formatnowa($data_siswa['no_rumah']);
            $nama = $data_siswa['nama'];
            $id_kelas = $data_siswa['id_kelas'];

            $pesan_wali = "📢 *Pemberitahuan Hasil Wawancara*\n\n"
                . "Yth. Bapak/Ibu Wali dari *$nama*,\n\n"
                . "Dengan bangga kami sampaikan bahwa peserta telah *lolos tahap wawancara (mensetsu)* pada:\n"
                . "🏢 *Perusahaan*: " . $POST['nama_perusahaan'] . "\n"
                . "🔧 *Bidang*: " . $POST['nama_job'] . "\n"
                . "📅 *Tanggal Lolos*: " . $POST['tgl_lolos'] . "\n\n"
                . "Ini adalah langkah awal dari perjalanan menuju negeri Sakura, *Jepang* 🇯🇵.\n"
                . "Mohon doa dan dukungan Bapak/Ibu agar proses selanjutnya dapat berjalan dengan lancar.\n\n"
                . "Terima kasih atas perhatian dan kerja samanya.\n"
                . "*おめでとうございます* — Selamat!\n\n"
                . "Hormat kami,\n"
                . "*Team Hikari Gakkou* 🇯🇵\n\n"
                . "ℹ️ *Dimohon untuk tidak membalas pesan ini.*\n";

            $pesan1 =["target"=> $no_wa,
                    "message" => $pesan_wali
            ];

            kirimfonnte($token,$pesan1);
            $this->db->simpanlolos($data,$tagihanList);

            header('Content-Type: application/json');
            ob_clean();
            echo json_encode([
                'success' => true,
                'message' => 'Peserta berhasil diloloskan.'
            ]);
            exit;
        }catch (\Exception $e) {
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Peserta gagal diloloskan dicontroller.' . $e->getMessage()
            ]);

        }
    }

    public function gagalpeserta($id_w){
        try{
            $this->db->hapuspeserta($id_w);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Peserta berhasil dihapus.'
            ]);
            exit;

        }catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Peserta gagal dihapus dicontroller.' . $e->getMessage()
            ]);

        }
    }
}