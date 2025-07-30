<?php
namespace app\controller;
use app\model\lolos;
use TCPDF;

class loloscontroller{
    private $db;

    public function __construct(){
        $this->db = new lolos();
    }

    public function daftarlolos($page) {
        if ($page == null) $page = '1';
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $model = $this->db;
        $data = $model->datalolos($limit, $offset);
        $total = $model->counttotallolos();
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ];
    }

    public function buattagihan(){
        try{
            $idtagihan = idbaru('T','id_tagihan','tagihan');
            $nis = $_POST['nis'];
            $tagihan = $_POST['tagihan'];
            $jenis_tagihan = $_POST['jenis_tagihan'];
            $data=[
                    'id_tagihan'=>$idtagihan,
                    'jenis_tagihan'=>$jenis_tagihan,
                    'biaya_tagihan' =>$tagihan,
                    'nis'=>$nis,
                    'status_tagihan'=>'Belum Lunas',
                    'sisa_tagihan' =>$tagihan
                ];
            $this->db->tambahtagihan($data);
            header('Content-Type: application/json');
                            echo json_encode([
                                'success' => true,
                                'message' => 'Tagihan sudah ditambahkan'
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

    public function tampiltagihan($id_tagihan){
        return $this->db->tampiltagihan($id_tagihan);
    }

    public function transaksi($post){
        $model = $this->db;
        try{
                $id_tagihan = $post['id_tagihan'];
                $jenis_tagihan = $post['jenis_tagihan'];
                $biaya_tagihan = $post['biaya_tagihan'];
                $sisa_tagihan = $post['sisa_tagihan'];
                $nis = $post['nis'];
                $status_tagihan = $post['status_tagihan'];
                $pembayaran = $post['pembayaran'];

                if($sisa_tagihan > $pembayaran){
                    $status_tagihan = "Belum Lunas";
                } else{
                    $status_tagihan = "Lunas";
                }
                $sisa_tagihan2 = $sisa_tagihan - $pembayaran;
                $d_tagihan=[
                    'id_tagihan'=>$id_tagihan,
                    'jenis_tagihan'=>$jenis_tagihan,
                    'biaya_tagihan' =>$biaya_tagihan,
                    'nis'=>$nis,
                    'status_tagihan'=>$status_tagihan,
                    'sisa_tagihan' =>$sisa_tagihan2
                ];
                $idtx = idbaru('TX','id_tx','log_pembayaran');
                $d_bayar =[
                    'id_tx'=>$idtx,
                    'nis'=>$nis,
                    'ket_bayar' => $jenis_tagihan,
                    'jumlah'=>$pembayaran,
                    'kekurangan'=>$sisa_tagihan2,
                    'tgl_bayar'=> date('Y-m-d')
                ];
                $model->updatetagihan($d_tagihan);
                $model->tx($d_bayar);

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Berhasil melakukan pembayaran'
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

    public function detaillolos($nis,$tipe){
        
        $model = $this->db; 
        // Validasi cepat
        $allowedTypes = ['data' => 'siswa', 'lolosjob' => 'lolos', 'keluarga' => 'keluarga','tagihan'=>'tagihan','transaksi'=>'transaksi'];

        if (!isset($allowedTypes[$tipe])) {
            return null;
        }

    return $model->detail($nis, $allowedTypes[$tipe]);
    }

    public function updatelolos($post,$files){
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
                    $oldPath = '/mnt/nas/photos/' . $lama['foto'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $targetDir  =  '/mnt/nas/photos/';
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
    
    public function cetakkuitansi($id_tx){
        ob_clean(); 
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('LPK HIKARI');
        $pdf->SetTitle('TCPDF KUITANSI');
        $pdf->SetSubject('TCPDF KUITANSI');
        $pdf->SetKeywords('KUITANSI');
            
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
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);
        $row = $this->db->kuitansi($id_tx);
        
        foreach($row as $v){
            $nama = $v['nama'];
            $tgl_bayar = $v['tgl_bayar'];
            $ket_bayar = $v['ket_bayar'];
            $jumlah = number_format($v['jumlah'],0,".",",");
            $kekurangan = number_format($v['kekurangan'],0,".",",");
        }
        $pdf->Image('../../public/image/asset/kuitansi.jpg', 6,7, 197.534,69.25, 'JPG', '', '', false, 200, '', false, false, 0, false, false, false);
        $pdf->setXY(166,9.7);
        $pdf->Cell(123,8,$id_tx,0,1,'L');
        $pdf->setXY(68,24);
        $pdf->Cell(121,6,$tgl_bayar,0,1,'L');
        $pdf->setXY(68,32);
        $pdf->Cell(121,6,$nama,0,1,'L');
        $pdf->setXY(68,39.6);
        $pdf->Cell(121,6,"Rp. ".$jumlah,0,1,'L');
        $pdf->setXY(68,47.3);
        $pdf->Cell(121,6,$ket_bayar,0,1,'L');
        $pdf->setXY(68,55.7);
        $pdf->Cell(121,6,"Rp. ".$kekurangan,0,1,'L');
        $pdf->Output($nama.'.pdf', 'I');
        exit;
        }
    function getFileIcon($ext) {
    $exts = pathinfo($ext, PATHINFO_EXTENSION);
    $icons = [
        'pdf'  => '<i class="fa fa-file-pdf text-red-500 text-xl"></i>',
        'doc'  => '<i class="fa fa-file-word text-blue-500 text-xl"></i>',
        'docx' => '<i class="fa fa-file-word text-blue-500 text-xl"></i>',
        'xls'  => '<i class="fa fa-file-excel text-green-500 text-xl"></i>',
        'xlsx' => '<i class="fa fa-file-excel text-green-500 text-xl"></i>',
        'jpg'  => '<i class="fa fa-file-image text-purple-500 text-xl"></i>',
        'jpeg' => '<i class="fa fa-file-image text-purple-500 text-xl"></i>',
        'png'  => '<i class="fa fa-file-image text-purple-500 text-xl"></i>',
        'txt'  => '<i class="fa fa-file-alt text-gray-500 text-xl"></i>',
        'zip'  => '<i class="fa fa-file-archive text-yellow-500 text-xl"></i>',
        'rar'  => '<i class="fa fa-file-archive text-yellow-500 text-xl"></i>',
        'default' => '<i class="fa fa-file text-gray-400 text-xl"></i>',
    ];
    return $icons[$exts] ?? $icons['default'];
}

    public function lihatdokumen($nis){
        return $this->db->lihatdokumen($nis);
    }

    public function downloadfile($get)
{
    $tipe = $get['tipe'] ?? '';
    $dokumen = $get['file'] ?? '';

    // Security: bersihkan input
    $safeTipe = preg_replace('/[^a-zA-Z0-9_\-]/', '', $tipe);
    $safeFile = basename($dokumen);

    $path = "/mnt/nas/$safeTipe/$safeFile";

    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    } else {
        echo "File tidak ditemukan.";
    }
}
}