<?php
namespace app\controller;
use app\model\siswa;
use TCPDF;
require_once __DIR__ . '/../../autoloader.php';


class siswacontroller{
    private $db;

    public function __construct(){
        $this->db = new Siswa();
    }

    public function daftarkelas(){
        return $this->db->semuakelas();
    }

    public function daftarsiswa($id_kelas){
        return $this->db->siswaperkelas($id_kelas);
    }

    public function detailsiswa($nis,$tipe){
        
        $model = $this->db; 
        // Validasi cepat
        $allowedTypes = ['data' => 'siswa', 'job' => 'job', 'keluarga' => 'keluarga', 'pendidikan' => 'pendidikan'];
        
        // Buat QR Code (sekali saja per siswa, dicek dulu)
        require_once __DIR__."/../lib/phpqrcode/qrlib.php";
        $qrDir = __DIR__."/../lib/phpqrcode/qrlib.php";
        $qrtext = $nis;
        $qrfile = __DIR__.'/../../public/image/qr_images/'.$nis.'.png';
        
        \QRcode::png($qrtext, $qrfile, QR_ECLEVEL_L, 4);

        if (!isset($allowedTypes[$tipe])) {
            return null;
        }

    return $model->detail($nis, $allowedTypes[$tipe]);
    }

    public function hapussiswa($nis){
        try{
            $this->db->hapus($nis);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Siswa berhasil dihapus.'
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
    public function updatesiswa($post,$files){
        try{
            $data = [
            'nis'           => $post['nis'],
            'nama_lengkap'  => $post['nama_lengkap'] ?? '',
            'panggilan'     => $post['panggilan'] ?? '',
            'id_kelas'      => $post['id_kelas'] ?? '',
            'tempat_lahir'  => $post['tempat_lahir'] ?? '',
            'gender'        => $post['gender'] ?? '',
            'tgl'           => $post['tgl'] ?? '',
            'provinsi'      => $post['provinsi'] ?? '',
            'kab'           => $post['kab'] ?? '',
            'kec'           => $post['kec'] ?? '',
            'rt'            => $post['rt'] ?? '',
            'rw'            => $post['rw'] ?? '',
            'wa'            => $post['wa'] ?? '',
            'agama'         => $post['agama'] ?? '',
            'status'        => $post['status'] ?? '',
            'darah'         => $post['darah'] ?? '',
            'bb'            => $post['bb'] ?? '',
            'tb'            => $post['tb'] ?? '',
            'merokok'       => $post['merokok'] ?? '',
            'alkohol'       => $post['alkohol'] ?? '',
            'tangan'        => $post['tangan'] ?? '',
            'hobi'          => $post['hobi'] ?? '',
            'tujuan'        => $post['tujuan'] ?? '',
            'kelebihan'     => $post['kelebihan'] ?? '',
            'kekurangan'    => $post['kekurangan'] ?? '',
            'no_rumah'      => $post['no_rumah'] ?? '',
            'foto' => null,
            ];
            // jika upload foto
            if (isset($files['foto']) && $files['foto']['error'] === 0) {
                $ekstensi = pathinfo($files['foto']['name'], PATHINFO_EXTENSION);
                $fotoName = strtolower($post['nama_lengkap']) . '.' . $ekstensi;
                $lama = findById('siswa','nis',$post['nis']);
                if (!empty($lama['foto'])) {
                    $oldPath = __DIR__ . '/../../public/image/photos/' . $lama['foto'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $targetDir  = __DIR__ . '/../../public/image/photos/';
                $targetPath = $targetDir . $fotoName;

                // Cek apakah path folder-nya ada
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // bikin folder kalau belum ada
                }

                if (!move_uploaded_file($files['foto']['tmp_name'], $targetPath)) {
                    throw new \Exception("Gagal upload foto ke $targetPath");
                }
                $data['foto'] = $fotoName;

            }

            $this->db->updatesiswa($data);
            header('Content-Type: application/json');
                        echo json_encode([
                            'success' => true,
                            'message' => 'Siswa berhasil diedit!'
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

    public function uploaddokumen($post,$files){
    header('Content-Type: application/json');

    try {
        $nama = $post['nama'] ?? '';
        $nis = $post['nis'] ?? '';
        $tipe = $post['tipe'] ?? '';
        $keterangan = $post['keterangan'] ?? '';

        $originalName = $files['dokumen']['name'];
        $tmpPath = $files['dokumen']['tmp_name'];
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        $safeNama = preg_replace('/[^a-zA-Z0-9_\-]/', '', str_replace(' ', '_', $nama));
        $safeTipe = strtoupper(preg_replace('/[^a-zA-Z0-9_\-]/', '', str_replace(' ', '_', $tipe)));
        $safeKeterangan = preg_replace('/[^a-zA-Z0-9_\-]/', '', str_replace(' ', '_', $keterangan));

        $label = ($tipe === 'LAINNYA') ? $safeKeterangan : $safeTipe;
        $newFileName = "{$nis}_{$safeNama}_{$label}." . strtolower($ext);

        // Buat folder tujuan kalau belum ada
        $folderTujuan = "/mnt/nas/{$safeTipe}";
        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0775, true);
        }

        // Pindahkan file
        $tujuan = $folderTujuan . '/' . $newFileName;
        $success = move_uploaded_file($tmpPath, $tujuan);

        file_put_contents('/tmp/debug.log', 'Move: ' . ($success ? 'yes' : 'no') . "\n", FILE_APPEND);
        file_put_contents('/tmp/debug_path.log', "TMP: $tmpPath\nDEST: $tujuan\n", FILE_APPEND);
        if (!$success) {
            throw new \Exception("Gagal memindahkan file ke NAS.");
        }
        
        // if (!move_uploaded_file($tmpPath, $tujuan)) {
        //     file_put_contents('/tmp/debug.log', 'Move: ' . ($success ? 'yes' : 'no') . "\n", FILE_APPEND);
        //     throw new \Exception("Gagal memindahkan file ke NAS.");
        // }

        // Simpan ke database
        $data = [
            'id_doc' => idBaru('DOC','id_doc','dokumen'),
            'nis' => $nis,
            'tipe' => $tipe,
            'keterangan' => $keterangan,
            'dokumen' => $newFileName
        ];
        $this->db->uploaddokumen($data);

        echo json_encode([
            'success' => true,
            'message' => 'Dokumen berhasil diupload dan disimpan.'
        ]);
        exit;

    } catch(\Throwable $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
        exit;
    }
}
    
    public function lihatdokumen($nis){
        return $this->db->lihatdokumen($nis);
    }
    public function insertsiswa($post,$files){
        try{
            $data = [
            'nis'           => idBaru('','nis','siswa'),
            'nama'  => $post['nama_lengkap'] ?? '',
            'panggilan'     => $post['nama_panggilan'] ?? '',
            'id_kelas'      => '4',
            'tempat_lhr'  => $post['tempat_lahir'] ?? '',
            'gender'        => $post['gender'] ?? '',
            'tgl'           => $post['tgl_lahir'] ?? '',
            'provinsi'      => $post['provinsi'] ?? '',
            'kabupaten'           => $post['kabupaten'] ?? '',
            'kecamatan'           => $post['kecamatan'] ?? '',
            'kelurahan'           => $post['kelurahan'] ?? '',
            'rt'            => $post['rt'] ?? '',
            'rw'            => $post['rw'] ?? '',
            'wa'            => $post['wa'] ?? '',
            'agama'         => $post['agama'] ?? '',
            'status'        => $post['status'] ?? '',
            'darah'         => $post['darah'] ?? '',
            'bb'            => $post['bb'] ?? '',
            'tb'            => $post['tb'] ?? '',
            'merokok'       => $post['rokok'] ?? '',
            'alkohol'       => $post['alkohol'] ?? '',
            'tangan'        => $post['tangan'] ?? '',
            'hobi'          => $post['hobi'] ?? '',
            'tujuan'        => $post['tujuan'] ?? '',
            'kelebihan'     => $post['kelebihan'] ?? '',
            'kekurangan'    => $post['kekurangan'] ?? '',
            'no_rumah'      => $post['no_rumah'] ?? '',
            'foto' => null,
            ];
            // jika upload foto
            if (isset($files['foto']) && $files['foto']['error'] === 0) {
                $ekstensi = pathinfo($files['foto']['name'], PATHINFO_EXTENSION);
                $fotoName = strtolower($post['nama_lengkap']) . '.' . $ekstensi;
                
                $targetDir  = __DIR__ . '/../../public/image/photos/';
                $targetPath = $targetDir . $fotoName;

                // Cek apakah path folder-nya ada
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true); // bikin folder kalau belum ada
                }

                if (!move_uploaded_file($files['foto']['tmp_name'], $targetPath)) {
                    throw new \Exception("Gagal upload foto ke $targetPath");
                }
                $data['foto'] = $fotoName;

            }

            $this->db->insertsiswa($data);
            echo "selamat bergabung";
            exit;
        }catch( \Throwable $e){
            echo "error" . $e->getMessage();;
                exit;
        }
    }

    public function daftar_wawancara(){
        return $this->db->daftar_wawancara();
    }

    
    public function tambahjob($post){
        try {
            $id = $post['id_job'];
            $id_w = idBaru('W','id_w','wawancara');
            $nis = $post['nis'];
            $data = [
                'id_job' => $id,
                'id_w' => $id_w,
                'nis' => $nis
            ];

            $this->db->tambahjob($data);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Training Order berhasil ditambahkan!'
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
    public function cetaknafuda($nis) {
        $model = new Siswa();
        $data = $model->detail($nis,'siswa'); // ambil data siswa
        foreach($data as $d){
            $nama = $d['nama'];
            $panggilan = $d['panggilan'];
        }
        ob_end_clean(); 
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // define('K_PATH_FONTS', __DIR__ . '/../../public/fonts/');
        // require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Wahyu Agung');
        $pdf->SetTitle('TCPDF QRCODE');
        $pdf->SetSubject('TCPDF QRCODE');
        $pdf->SetKeywords('QRCODE');
            
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // set default monospaced font
        $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        
        // set auto page breaks
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        
        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'ltr';
        $lg['a_meta_language'] = 'ja';
        $lg['w_page'] = 'page';
        $pdf->setLanguageArray($lg);
            
        // set font
        
        $pdf->SetFont('dfminchoub', '', 28);
        
        // add a page
        $pdf->AddPage();
        
        // kuery data
        $filename =  $nis;
        $qr_image = __DIR__."/../../public/image/qr_images/" . $filename . ".png";
        $gambar = dirname(__DIR__)."/../public/image/asset/";
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
        $pdf->Image($gambar.'name_tag.jpg', 14.92,11.368,90,55, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->Image($gambar.'name_tag2.jpg', 104.92,11.368,90,55,'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->Image($qr_image, 18, 29, 17, 17,'PNG', '', '', false, 150, '', false, false, 0, false, false, false); // Lokasi, ukuran QR Code
        $pdf->Image($qr_image, 110, 29, 17, 17,'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        
        // Kolom untuk nama pertama
        // $pdf->Cell(90, 0, $panggilan, 0, 0, 'C'); // Nama pertama di tengah
        
        
        $pdf->SetXY(37, 29); // Set posisi
        $pdf->MultiCell(70, 12, $panggilan, 0, 'L'); // Menulis teks
        
        $pdf->SetXY(129, 29); // Set posisi
        $pdf->settextColor(255,255,255);
        $pdf->MultiCell(70, 12, $panggilan, 0,'L'); // Menulis teks
        // set content print
        $html =  <<<EOD
        
            EOD;
            
        $pdf->writeHTML($html, true, false, true, false, '');
        return $pdf->Output($nama.'.pdf', 'I');
        

    }
}