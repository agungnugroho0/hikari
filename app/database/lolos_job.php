<?php
require_once '../../autoloader.php';
admin();

$nis = $_POST['nis'];
$tgl_lolos = $_POST['tgl_lolos'];
$so = $_POST['so'];
$job = $_POST['job'];
$perusahaan = $_POST['perusahaan'];
// $hikari = $_POST['hikari'];
$hikari = str_replace('.', '', $_POST['hikari']);
$tagihan_so = str_replace('.', '', $_POST['tagihan_so']);

$loglolos = idbaru('LLS','id_loglolos','log_lolos');
$tagihan = idbaru('T','id_tagihan','tagihan');
$prefix = substr($tagihan,0,-3);
$angka = (int) substr($tagihan,-3);
$angka_baru = $angka+1;
$idtagihan2 = $prefix . str_pad($angka_baru, 3, '0', STR_PAD_LEFT);

$d_loglolos=[
    ':id_loglolos'=>$loglolos,
    ':nis'=>$nis,
    ':tgl_lolos'=>$tgl_lolos,
    ':so'=>$so,
    ':job'=>$job,
    ':perusahaan'=>$perusahaan
];
$d_tagihan1=[
    ':id_tagihan'=>$tagihan,
    ':jenis_tagihan'=>'Biaya Hikari',
    ':biaya_tagihan' =>$hikari,
    ':nis'=>$nis,
    ':status_tagihan'=>'Belum Lunas',
    ':sisa_tagihan' =>$hikari
];
$d_tagihan2=[
    ':id_tagihan'=>$idtagihan2,
    ':jenis_tagihan'=>'Biaya SO '.$so,
    ':biaya_tagihan' =>$tagihan_so,
    ':nis'=>$nis,
    ':status_tagihan'=>'Belum Lunas',
    ':sisa_tagihan' =>$tagihan_so
];
$wawancara = [
    ':nis'=>$nis
];
// coba API kelulusan siswa
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

$no_wasiswa = tampil("SELECT wa,nama,id_kelas FROM siswa WHERE nis = '$nis'");
foreach ($no_wasiswa as $no){$no_wa = formatnowa($no['wa']);$nama= $no['nama'];$idkls = $no['id_kelas'];};
$no_sensei = tampil("SELECT no,nama FROM staff WHERE id_kelas = '$idkls'");
foreach ($no_sensei as $s){$no_s = $s['no'];$nama_s = $s['nama'];};


$pesan_siswa = "🎉 Selamat, *$nama* !\n\n"
. "Kamu telah dinyatakan *LOLOS MENSETSU* pada perusahaan $perusahaan pada bidang $job.\n\n"
. "📅 Tanggal Lolos: $tgl_lolos\n\n"
. "Terus semangat, jaga kesehatan dan jaga sikap, karena ini adalah awal dari perjalananmu menuju Jepang 🇯🇵✨\n\n"
. "おめでとうございます！\n\n"
. "Salam,\nTeam Hikari Gakkou";

$pesan_sensei = "👨‍🏫 Kepada Yth. $nama_s Sensei,\n\n"
    . "Kami informasikan bahwa siswa atas nama:\n\n"
    . "👤 Nama : $nama\n"
    . "🏢 Perusahaan : $perusahaan\n"
    . "💼 Bidang: $job\n"
    . "📅 Tanggal Lolos : $tgl_lolos\n\n"
    . "Telah *LOLOS MENSETSU* \n\n"
    . "Terima kasih atas bimbingan dan dukungan dari Sensei selama ini 🙏\n\n"
    . "お疲れ様でした";

$pesan1 =["target"=> $no_wa,
        "message" => $pesan_siswa
];
$pesan2 =["target"=> $no_s,
        "message" => $pesan_sensei ];

@kirimfonnte($token,$pesan1);
@kirimfonnte($token,$pesan2);

// print_r ($pesan1);
masukan('log_lolos',$d_loglolos);
masukan('tagihan',$d_tagihan1);
masukan('tagihan',$d_tagihan2);
pindahkanData('lolos','siswa',$nis);
hapus('wawancara',$wawancara);
hapus('siswa',$wawancara);
hapus('absen',$wawancara);


echo "
    <script>
    window.top.location.href= '/public/admin/index.php?menu_Id=3&sukses';
    </script>
";
