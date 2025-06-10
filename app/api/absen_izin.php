<?php
require '../../autoloader.php';
$nis = $_POST['nis'];
$ket = $_POST['status'];
$tgl = date('Y-m-d');
//validasi apakah siswa sudah absen hari ini
$result = tampil("SELECT COUNT(*) AS count FROM absen WHERE nis = '$nis' AND tgl = '$tgl'");
foreach ($result as $row) {
    $result = $row['count'];
};
if ($result > 0) {
    echo "Siswa sudah melakukan Presensi hari ini";
    exit;
};
$siswa = tampil("SELECT nama,no_rumah FROM siswa WHERE nis = $nis");
foreach ($siswa as $data) {
    $nama = $data['nama'];
    $no_rumah = $data['no_rumah'];
};
$id_absen = idbaru('ABS', 'id_absen', 'absen');
$data = [
    ':id_absen' => $id_absen,
    ':nis' => $nis,
    ':nama' => $nama,
    ':tgl' => $tgl,
    ':ket' => $ket
];

if ($ket =='A'){
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

    $token = "vXze72HNXjgiDio2Z9HK";
    $pesan_siswa = "Yth. Bapak/Ibu Wali dari ". $nama .",\n\n" .
                  "Dengan hormat,\n\n" .
                  "Kami ingin memberitahukan bahwa Saudara ". $nama ." tidak hadir di sekolah pada hari ini, ". $tgl .", tanpa keterangan.\n\n" .
                  "Berdasarkan keterangan dari guru wali, Saudara " . $nama . " dinyatakan *Alpha* (tidak hadir tanpa alasan yang jelas).\n\n" .
                  "Mohon kerja sama Bapak/Ibu untuk dapat menanyakan perihal ketidakhadiran siswa. Apabila ada kendala atau alasan yang perlu disampaikan, mohon segera menghubungi pihak sekolah melalui *088975452668* atau membalas pesan ini.\n\n" .
                  "Terima kasih atas perhatian dan kerja sama Bapak/Ibu.\n\n" .
                  "Hormat kami,\n" .
                  "*LPK Hikari Gakkou*";
    $pesan =["target"=> $no_rumah,    
            "message" => $pesan_siswa
    ];
    // @kirimfonnte($token,$pesan);


}

// kirim pesan ke fonnte


masukan('absen',$data);
echo 'Presensi sudah masuk';