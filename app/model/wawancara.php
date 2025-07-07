<?php
namespace app\model;
use app\core\Database;

class wawancara{
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function tampilwawancara(){
        $query = "SELECT 
                    so.id_so,
                    so.so,
                    so.foto_so,
                    job.job,
                    job.id_job,
                    job.perusahaan,
                    job.tgl_job,
                    wawancara.id_w,
                    siswa.nama,
                    job.interview,
                    job.penempatan
                FROM 
                    so
                JOIN 
                    job ON job.id_so = so.id_so
                LEFT JOIN 
                    wawancara ON wawancara.id_job = job.id_job
                LEFT JOIN 
                    siswa ON wawancara.nis = siswa.nis";
        
        $data = $this->db->prepare($query);
        $data->execute();
        return $data->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function data_so(){
        $query = "SELECT * FROM so";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function simpan($data){
        $query = "INSERT INTO job (id_job, job, perusahaan, id_so, tgl_job, interview, penempatan) 
          VALUES (:id_job, :job, :perusahaan, :id_so, :tgl_job, :interview, :penempatan)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_job',$data['id_job']);
        $stmt->bindParam(':job',$data['job']);
        $stmt->bindParam(':perusahaan',$data['perusahaan']);
        $stmt->bindParam(':id_so',$data['id_so']);
        $stmt->bindValue(':tgl_job', $data['tgl_job'] ?: null);
        $stmt->bindParam(':interview',$data['interview']);
        $stmt->bindParam(':penempatan',$data['penempatan']);
        return $stmt->execute();
    }

    public function update($data) {
        $stmt = $this->db->prepare("
            UPDATE job SET 
                job = :job,
                perusahaan = :perusahaan,
                interview = :interview,
                penempatan = :penempatan,
                tgl_job = :tgl_job
            WHERE id_job = :id_job
        ");

        return $stmt->execute([
            ':job' => $data['job'],
            ':perusahaan' => $data['perusahaan'],
            ':interview' => $data['interview'],
            ':penempatan' => $data['penempatan'],
            ':tgl_job' => $data['tgl_job'],
            ':id_job' => $data['id_job']
        ]);
    }

    public function hapus($id_job){
        $query1 = "DELETE FROM wawancara WHERE id_job = ?";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->execute([$id_job]);
        $query = "DELETE FROM job WHERE id_job = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id_job]);
    }

    public function daftarsiswa(){
        $query = "SELECT s.nis, s.nama, k.kelas,w.id_w FROM siswa s JOIN kelas k ON s.id_kelas = k.id_kelas LEFT JOIN wawancara w ON w.nis = s.nis ORDER BY k.id_kelas, s.nama;";
        $stmt = $this->db->prepare($query);
         $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function tambahPeserta($data){
    // Cek apakah kombinasi id_job dan nis sudah ada
    $cek = $this->db->prepare("SELECT COUNT(*) FROM wawancara WHERE id_job = :id_job AND nis = :nis");
    $cek->bindParam(':id_job', $data['id_job']);
    $cek->bindParam(':nis', $data['nis']);
    $cek->execute();
    $sudahAda = $cek->fetchColumn();

    if ($sudahAda > 0) {
        // Sudah ada, skip insert
        return false;
    }

    $stmt = $this->db->prepare("INSERT INTO wawancara (id_w, id_job, nis) VALUES (:id_w, :id_job, :nis)");
    $stmt->bindParam(':id_w', $data['id_w']);
    $stmt->bindParam(':id_job', $data['id_job']);
    $stmt->bindParam(':nis', $data['nis']);
    return $stmt->execute();
    }

    public function dataloglolos($id_w){
        $stmt = $this->db->prepare("SELECT w.nis,j.job,j.perusahaan,so.so,siswa.nama FROM wawancara w JOIN job j ON w.id_job = j.id_job JOIN so ON j.id_so = so.id_so JOIN siswa ON w.nis = siswa.nis WHERE w.id_w = :id_w");
        $stmt->bindParam(':id_w',$id_w);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function datasiswa($nis){
        $stmt = $this->db->prepare("SELECT * FROM siswa WHERE nis = :nis");
        $stmt->bindParam(':nis',$nis);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function datasensei($id_kelas){
        $stmt = $this->db->prepare("SELECT nama,no FROM staff WHERE id_kelas = :id_kelas");
        $stmt->bindParam(':id_kelas',$id_kelas);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function simpanlolos($data,$tagihanList){
        try{
                $this->db->beginTransaction(); //->mulai transaksi
                $cek = $this->db->prepare("SELECT COUNT(*) FROM log_lolos WHERE nis = :nis");
                $cek->execute([':nis' => $data['nis']]);
                if ($cek->fetchColumn() > 0) {
                    // sudah ada, jangan insert ulang
                    return;
                }
                $stmtLog = $this->db->prepare(
                    "INSERT INTO log_lolos (id_loglolos, nis, tgl_lolos, so, job, perusahaan) 
                            VALUES (:id_loglolos, :nis, :tgl_lolos, :so, :job, :perusahaan)");
                $stmtLog->execute([
                    ':id_loglolos' => $data['id_loglolos'],
                    ':nis' => $data['nis'],
                    ':tgl_lolos' => $data['tgl_lolos'],
                    ':so' => $data['so'],
                    ':job' => $data['job'],
                    ':perusahaan' => $data['perusahaan']
                ]);

                $stmtTagihan = $this->db->prepare(
                    "INSERT INTO tagihan (id_tagihan, jenis_tagihan, biaya_tagihan, nis, status_tagihan, sisa_tagihan) 
                            VALUES (:id_tagihan,:jenis_tagihan, :biaya_tagihan,  :nis,:status_tagihan,  :sisa_tagihan)");
                foreach ($tagihanList as $tagihan) {
                    $stmtTagihan->execute([
                        'id_tagihan'=> $tagihan['id_tagihan'],
                        'jenis_tagihan' => $tagihan['jenis_tagihan'],
                        'biaya_tagihan' => $tagihan['biaya_tagihan'],
                        'nis' => $tagihan['nis'],
                        'status_tagihan' => $tagihan['status_tagihan'],
                        'sisa_tagihan' => $tagihan['sisa_tagihan']
                    ]);
                }

                // Simpan ke tabel lolos
                $stmtLolos = $this->db->prepare("INSERT INTO lolos SELECT * FROM siswa WHERE nis = :nis");
                $stmtLolos->execute([':nis' => $data['nis']]);
                //hapus dari tbel absensi
                $stmtHapusAbsen = $this->db->prepare("DELETE FROM absen WHERE nis = :nis");
                $stmtHapusAbsen->execute([':nis' => $data['nis']]);
                //Hapus dari tabel siswa
                $stmtHapus = $this->db->prepare("DELETE FROM siswa WHERE nis = :nis");
                $stmtHapus->execute([':nis' => $data['nis']]);
                // hapus dari tabel wawancara
                $stmtHapusW = $this->db->prepare("DELETE FROM wawancara WHERE nis = :nis");
                $stmtHapusW->execute([':nis' => $data['nis']]);
                $this->db->commit();
                return true;
        } catch (\Exception $e) {
                $this->db->rollBack();
                throw $e;
    }
    }

    public function hapuspeserta($id_w){
        $stmt = $this->db->prepare("DELETE FROM wawancara WHERE id_w = :id");
        $stmt->bindParam(':id', $id_w);
        $stmt->execute();
    }
}