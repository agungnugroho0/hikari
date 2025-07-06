<?php
namespace app\controller;
use app\model\so;

class socontroller{
    private $db;

    public function __construct(){
        $this->db = new so();
    }
    
    public function tampilsocontroller(){
        return $this->db->tampilso();
    }

    public function simpanso(){
        try{
            $foto_so =$_FILES['foto_so'];
            $nama_so =$_POST['nama_so'];

            // prosesuploadfoto
            $ekstensi = pathinfo($foto_so['name'], PATHINFO_EXTENSION);
            $fotoName = strtolower($nama_so) . '.' . $ekstensi;
            $targetPath = __DIR__ . '/../../public/image/img_so/' . $fotoName;
            // hapus foto lama jika username pernah dipakai
            if (file_exists($targetPath)) {
               unlink($targetPath);
            }
            move_uploaded_file($foto_so['tmp_name'],$targetPath);

            $data=[
                'id_so' =>idBaru('so','id_so','so'),
                'so' => $_POST['nama_so'],
                'lokasi' => $_POST['lokasi'],
                'foto_so' => $fotoName

            ];
            $this->db->simpan($data);

         header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'SO berhasil ditambahkan!'
            ]);
            exit;
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;   
        }
    }
}