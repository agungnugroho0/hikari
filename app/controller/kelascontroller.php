<?php
namespace app\controller;
use app\model\kelas;

class kelascontroller{
    private $db;

    public function __construct(){
        $this->db = new Kelas();
    }

    public function tampil(){
        $model = $this->db;
        return $model->tampil();
    }
    public function semuakelas(){
        $model = $this->db;
        return $model->semuakelas();
    }
    public function pilihkelas($id_kelas){
        return $this->db->pilihkelas($id_kelas);
    }
    public function simpan($post){
        $model = $this->db;
        try{
            $data=[
                'id_kelas' => idBaru('','id_kelas','kelas'),
                'kelas' => $post['kelas'],
                'tingkat' => $post['tingkat']
            ];

            $model->simpan($data);

            // Balas dengan JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Kelas berhasil ditambahkan!'
            ]);
            exit;
        }catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public function update($post){
        try{
            $model = $this->db;
            $data=[
                'id_kelas' => $post['id_kelas'],
                'kelas' => $post['kelas'],
                'tingkat' => $post['tingkat']
            ];
            $model->update($data);

            // Balas dengan JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Kelas berhasil diedit!'
            ]);
            exit;
        }catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public function hapuskelas($id_kelas){
        try{
            $model = $this->db;
            $model->hapuskelas($id_kelas);

            // Balas dengan JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Kelas berhasil dihapus!'
            ]);
            exit;
        }catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }
}