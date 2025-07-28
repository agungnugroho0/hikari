<?php
namespace app\model;
use app\core\Database;

class Siswa{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }

    public function pilihsiswa($nis){
        $stmt = $this->db->prepare("SELECT nis,nama,no_rumah,id_kelas FROM siswa WHERE nis = :nis");
        $stmt->bindParam(':nis',$nis);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    public function semuakelas(){
        $stmt = $this->db->query("SELECT id_kelas,kelas FROM kelas");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function siswaperkelas($id_kelas){
        $stmt = $this->db->prepare("SELECT s.nis, s.nama, s.tgl, s.foto, s.wa, w.id_job, j.tgl_job
                                FROM siswa s
                                LEFT JOIN wawancara w ON s.nis = w.nis AND w.id_w = (
                                    SELECT MAX(id_w) FROM wawancara WHERE nis = s.nis
                                )
                                LEFT JOIN job j ON w.id_job = j.id_job
                                WHERE s.id_kelas = :id_kelas
                                ORDER BY s.gender, s.nama ASC
                                ");
        $stmt->bindParam(':id_kelas',$id_kelas);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function detail($nis,$tipe){
       $queryMap = [
        'siswa' => "SELECT s.*, kls.kelas FROM siswa s 
                    JOIN kelas kls ON s.id_kelas = kls.id_kelas 
                    WHERE s.nis = :nis",

        'job' => "SELECT w.*, s.nis, j.*, so.so, so.foto_so FROM wawancara w 
                  JOIN siswa s ON w.nis = s.nis 
                  JOIN job j ON w.id_job = j.id_job 
                  JOIN so ON j.id_so = so.id_so 
                  WHERE s.nis = :nis",

        'keluarga' => "SELECT * FROM kk WHERE nis = :nis ORDER BY urutan",

        'pendidikan' => "SELECT * FROM pendidikan WHERE nis = :nis"
    ];

    if (!array_key_exists($tipe, $queryMap)) {
        throw new \Exception("Jenis detail tidak dikenal: " . htmlspecialchars($tipe));
    }

    $stmt = $this->db->prepare($queryMap[$tipe]);
    $stmt->bindParam(':nis', $nis);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertsiswa($data){
    $query = "INSERT INTO siswa (nis, nama, panggilan, id_kelas, tempat_lhr, gender, tgl, provinsi, kabupaten, kecamatan,kelurahan,  rt, rw, wa, agama, status, darah, bb, tb, merokok, alkohol, tangan, hobi, tujuan, kelebihan, kekurangan, no_rumah, foto) 
              VALUES (:nis, :nama, :panggilan, :id_kelas, :tempat_lhr, :gender, :tgl, :provinsi, :kabupaten, :kecamatan,:kelurahan, :rt, :rw, :wa, :agama, :status, :darah, :bb, :tb, :merokok, :alkohol, :tangan, :hobi, :tujuan, :kelebihan, :kekurangan, :no_rumah, :foto)";
    $stmt = $this->db->prepare($query);
    foreach ($data as $key => $val) {
        echo "$key = $val <br>"; // Debugging
        $stmt->bindValue(":$key", $val);
        }
    return $stmt->execute();
    }

    function updatesiswa($data){
        foreach ($data as $key => $value) {
            if ($key !== 'foto') {
                $data[$key] = strtoupper($value);
            }
        }
        $query = "UPDATE siswa SET
        nama = :nama_lengkap,
        panggilan = :panggilan,
        id_kelas = :id_kelas,
        tempat_lhr = :tempat_lahir,
        gender = :gender,
        tgl = :tgl,
        provinsi = :provinsi,
        kabupaten = :kab,
        kecamatan = :kec,
        rt = :rt,
        rw = :rw,
        wa = :wa,
        agama = :agama,
        status = :status,
        darah = :darah,
        bb = :bb,
        tb = :tb,
        merokok = :merokok,
        alkohol = :alkohol,
        tangan = :tangan,
        hobi = :hobi,
        tujuan = :tujuan,
        kelebihan = :kelebihan,
        kekurangan = :kekurangan,
        no_rumah = :no_rumah
        ".(!empty($data['foto']) ? ", foto = :foto": "")." WHERE nis = :nis";
        $query = preg_replace('/,(\s*WHERE)/', ' $1', $query);

        $stmt = $this->db->prepare($query);

    // Binding semua data
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':panggilan', $data['panggilan']);
        $stmt->bindParam(':id_kelas', $data['id_kelas']);
        $stmt->bindParam(':tempat_lahir', $data['tempat_lahir']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':tgl', $data['tgl']);
        $stmt->bindParam(':provinsi', $data['provinsi']);
        $stmt->bindParam(':kab', $data['kab']);
        $stmt->bindParam(':kec', $data['kec']);
        $stmt->bindParam(':rt', $data['rt']);
        $stmt->bindParam(':rw', $data['rw']);
        $stmt->bindParam(':wa', $data['wa']);
        $stmt->bindParam(':agama', $data['agama']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':darah', $data['darah']);
        $stmt->bindParam(':bb', $data['bb']);
        $stmt->bindParam(':tb', $data['tb']);
        $stmt->bindParam(':merokok', $data['merokok']);
        $stmt->bindParam(':alkohol', $data['alkohol']);
        $stmt->bindParam(':tangan', $data['tangan']);
        $stmt->bindParam(':hobi', $data['hobi']);
        $stmt->bindParam(':tujuan', $data['tujuan']);
        $stmt->bindParam(':kelebihan', $data['kelebihan']);
        $stmt->bindParam(':kekurangan', $data['kekurangan']);
        $stmt->bindParam(':no_rumah', $data['no_rumah']);
        if (!empty($data['foto'])) $stmt->bindParam(':foto', $data['foto']);
        $stmt->bindParam(':nis', $data['nis']);
        return $stmt->execute();
    }

    public function hapus($nis){
    $stmt = $this->db->prepare("DELETE FROM siswa WHERE nis = :nis");
    $stmt->bindParam(':nis', $nis);
    return $stmt->execute();
    }

    public function daftar_wawancara(){
        $stmt = $this->db->query("SELECT j.*, s.* FROM job j JOIN so s ON j.id_so = s.id_so");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function tambahjob($data){
        $query = "INSERT INTO wawancara (id_w, id_job, nis) VALUES (:id_w, :id_job, :nis)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_w', $data['id_w']);
        $stmt->bindParam(':id_job', $data['id_job']);
        $stmt->bindParam(':nis', $data['nis']);
        return $stmt->execute();
    }

    public function uploaddokumen($data){
        $query = "INSERT INTO dokumen (id_doc, nis, tipe, keterangan, dokumen) VALUES (:id_doc, :nis,:tipe, :keterangan, :dokumen)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_doc', $data['id_doc']);
        $stmt->bindParam(':nis', $data['nis']);
        $stmt->bindParam(':tipe', $data['tipe']);
        $stmt->bindParam(':keterangan', $data['keterangan']);
        $stmt->bindParam(':dokumen', $data['dokumen']);
        return $stmt->execute();
    }

    public function lihatdokumen($nis){
        $stmt = $this->db->prepare("SELECT * FROM dokumen WHERE nis = :nis ");
        $stmt->bindParam(':nis', $nis);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function hapusdocdb($id_doc)
    {
    $stmt = $this->db->prepare("DELETE FROM dokumen WHERE id_doc = ?");
    return $stmt->execute([$id_doc]);
    }
}