<?php
namespace app\controller;
use app\model\staff;
use app\model\Kelas;

class staffcontroller{
    public function tampilstaffcontroller(){
        $data = (new staff())->tampilstaff();
        return $data;
    }   
    
    public function kelas(){
        $kelas = (new Kelas())->semuakelas();
        return $kelas;
    }

    public function simpan(){
        $model = new staff();
        try {
            $id_staff = $model->idBaru();
            $nama     = $_POST['nama_lengkap'];
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $level    = $_POST['akses'];
            $id_kelas    = $_POST['id_kelas'];
            $foto     = $_FILES['foto'];
            $no    = $_POST['no'];
            // upload foto
            $ekstensi = pathinfo($foto['name'], PATHINFO_EXTENSION);
            $fotoName = strtolower($username) . '.' . $ekstensi;
            $targetPath = __DIR__ . '/../../public/image/photos/' . $fotoName;
            // hapus foto lama jika username pernah dipakai
            if (file_exists($targetPath)) {
               unlink($targetPath);
            }
            move_uploaded_file($foto['tmp_name'],$targetPath);
            
            $data = [
                'id_staff'     => $id_staff,
                'nama'     => $nama,
                'username' => $username,
                'password' => $password,
                'level' => $level,
                'id_kelas' => $id_kelas,
                'no' => $no,
                'foto'     => $fotoName
            ];

            $model->simpan($data);

            // Balas dengan JSON
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Staff berhasil ditambahkan!'
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
            $data = [
            'id_staff' => $post['id_staff'],
            'nama' => $post['nama_lengkap'],
            'username' => $post['username'],
            'password' => !empty($post['password']) ? password_hash($post['password'], PASSWORD_DEFAULT) : null,
            'level' => $post['akses'],
            'id_kelas' => $post['id_kelas'],
            'foto' => null,
            'no' => $post['no']
            ];

        // jika upload foto baru
        if ($files['foto']['error'] === 0) {
                $ekstensi = pathinfo($files['foto']['name'], PATHINFO_EXTENSION);
                $fotoName = strtolower($post['username']) . '.' . $ekstensi;
                $lama = (new staff())->findById($post['id_staff']);
                if (!empty($lama['foto'])) {
                    $oldPath = __DIR__ . '/../../public/image/photos/' . $lama['foto'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                move_uploaded_file($files['foto']['tmp_name'], __DIR__ . '/../../public/image/photos/' . $fotoName);
                $data['foto'] = $fotoName;


            }

            (new staff())->update($data);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Staff berhasil diedit!'
            ]);
            exit;
        } catch(\Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
                exit;
        }
    }

    public function hapus($id_staff) {
        try {
            $model = new staff();
            $staff = $model->findById($id_staff);

            // hapus foto jika ada
            if (!empty($staff['foto'])) {
                $path = __DIR__ . '/../../public/image/photos/' . $staff['foto'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $model->hapus($id_staff);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Data staff berhasil dihapus.'
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