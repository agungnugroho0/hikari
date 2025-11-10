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

    public function update($post,$files){
        try{
            $data=[
                'id_so' => $post['id_so'],
                'so' => $post['so'],
                'lokasi' => $post['lokasi'],
                'noted' => $post['noted'],
                'pj' => $post['pj']
            ];

                    // jika upload foto baru
        if ($files['foto_so']['error'] === 0) {
        $ekstensi = pathinfo($files['foto_so']['name'], PATHINFO_EXTENSION);
        $fotoName = strtolower($post['so']) . '.' . $ekstensi;

        // ambil data lama
        $lama = (new so())->findById($post['id_so']);
        $targetPath = __DIR__ . '/../../public/image/img_so/' . $fotoName;

        // hapus foto lama (jika ada)
        if (!empty($lama['foto_so'])) {
            $oldPath = __DIR__ . '/../../public/image/img_so/' . $lama['foto_so'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // upload foto baru
        move_uploaded_file($files['foto_so']['tmp_name'], $targetPath);
        $data['foto_so'] = $fotoName;
     }
            $this->db->update($data);
        // ob_clean();
         header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'SO berhasil diupdate!'
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

    public function hapus($id_so) {
        try {
            $model = new so();
            $so = $model->findById($id_so);

            // hapus foto jika ada
            if (!empty($so['foto_so'])) {
                $path =__DIR__ . '/../../public/image/img_so/' . $so['foto_so'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $model->hapus($id_so);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Data SO berhasil dihapus.'
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
}