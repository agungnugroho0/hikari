<?php
namespace app\model;
use app\core\Database;

class lolos{
    private $db;
    public function __construct(){
        $this->db = (new Database())->connect();
    }    

    public function tambahtagihan($data){
        $query = "INSERT INTO tagihan (id_tagihan,jenis_tagihan,biaya_tagihan,nis,status_tagihan,sisa_tagihan) VALUES (:id_tagihan,:jenis_tagihan,:biaya_tagihan,:nis,:status_tagihan,:sisa_tagihan)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_tagihan',$data['id_tagihan']);
        $stmt->bindParam(':jenis_tagihan',$data['jenis_tagihan']);
        $stmt->bindParam(':biaya_tagihan',$data['biaya_tagihan']);
        $stmt->bindParam(':nis',$data['nis']);
        $stmt->bindParam(':status_tagihan',$data['status_tagihan']);
        $stmt->bindParam(':sisa_tagihan',$data['sisa_tagihan']);
        return $stmt->execute();

    }

    public function datalolos($limit, $offset){
        $query = "SELECT log_lolos.*,lolos.nama,lolos.nis,lolos.foto FROM log_lolos JOIN lolos ON log_lolos.nis = lolos.nis ORDER BY log_lolos.tgl_lolos DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit',$limit,\PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,\PDO::PARAM_INT);
         $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function counttotallolos() {
    $stmt = $this->db->query("SELECT COUNT(*) FROM log_lolos");
    return $stmt->fetchColumn();
    }

    public function tampiltagihan($id_tagihan){
        $stmt = $this->db->prepare("SELECT * FROM tagihan WHERE id_tagihan = :id_tagihan");
        $stmt->bindParam(':id_tagihan',$id_tagihan);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updatetagihan($data){
        $query = "UPDATE tagihan SET    jenis_tagihan = :jenis_tagihan,
                                        biaya_tagihan = :biaya_tagihan,
                                        nis = :nis,
                                        status_tagihan = :status_tagihan,
                                        sisa_tagihan = :sisa_tagihan
                                WHERE   id_tagihan = :id_tagihan
                                        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_tagihan', $data['id_tagihan'] );
        $stmt->bindParam(':jenis_tagihan', $data['jenis_tagihan'] );
        $stmt->bindParam(':biaya_tagihan', $data['biaya_tagihan'] );
        $stmt->bindParam(':nis', $data['nis'] );
        $stmt->bindParam(':status_tagihan', $data['status_tagihan'] );
        $stmt->bindParam(':sisa_tagihan', $data['sisa_tagihan'] );
        return $stmt->execute();

    }

    public function tx($data){
        $query = "INSERT INTO log_pembayaran (id_tx,nis,ket_bayar,jumlah,kekurangan,tgl_bayar)
                  VALUES (:id_tx,:nis,:ket_bayar,:jumlah,:kekurangan,:tgl_bayar)  ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_tx', $data['id_tx'] );
        $stmt->bindParam(':nis', $data['nis'] );
        $stmt->bindParam(':ket_bayar', $data['ket_bayar'] );
        $stmt->bindParam(':jumlah', $data['jumlah'] );
        $stmt->bindParam(':kekurangan', $data['kekurangan'] );
        $stmt->bindParam(':tgl_bayar', $data['tgl_bayar'] );
        return $stmt->execute();
    }

    public function kuitansi($id){
        $stmt = $this->db->prepare("SELECT log_pembayaran.*,lolos.nis,lolos.nama FROM log_pembayaran JOIN lolos ON log_pembayaran.nis = lolos.nis WHERE log_pembayaran.id_tx = :id_tx");
        $stmt->bindParam(':id_tx', $id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function detail($nis,$tipe){
        $queryMap=[
            'siswa'     => "SELECT s.*, kls.kelas FROM lolos s 
                        JOIN kelas kls ON s.id_kelas = kls.id_kelas 
                        WHERE s.nis = :nis",
            'lolos'  => "SELECT l.tgl_lolos, l.so, l.job, l.perusahaan, so.so, so.foto_so
                        FROM log_lolos l
                        JOIN so ON l.so = so.so
                        WHERE nis = :nis",
            'transaksi' => "SELECT * FROM log_pembayaran WHERE nis = :nis",
            'tagihan'   => "SELECT id_tagihan, status_tagihan, sisa_tagihan, jenis_tagihan FROM tagihan WHERE nis = :nis"    
        ];

        if (!array_key_exists($tipe, $queryMap)) {
        throw new \Exception("Jenis detail tidak dikenal: " . htmlspecialchars($tipe));
    }

        $stmt = $this->db->prepare($queryMap[$tipe]);
        $stmt->bindParam(':nis', $nis);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    function updatesiswa($data){
        foreach ($data as $key => $value) {
            if ($key !== 'foto') {
                $data[$key] = strtoupper($value);
            }
        }
        $query = "UPDATE lolos SET
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
}