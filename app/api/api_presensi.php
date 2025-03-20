<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';

$bulan = $_GET['bulan'];
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : 'A';

$kls = tampil("SELECT * FROM kelas WHERE kelas = '$kelas' OR id_kelas = '$kelas'");
foreach ($kls as $k) {
    $kelas = $k['kelas'];
}

$bln = substr($bulan,-2);
$thn = substr($bulan,0,4);
$jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$bln,$thn);

$siswa = tampil("SELECT nis, nama FROM siswa 
    INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
    WHERE kelas.kelas = '$kelas'
    ORDER BY siswa.nama");

$presensi = tampil("SELECT siswa.nis, siswa.nama, absen.tgl, absen.ket 
    FROM absen 
    INNER JOIN siswa ON absen.nis = siswa.nis 
    INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
    WHERE DATE_FORMAT(absen.tgl, '%Y-%m') = '$bulan' AND kelas.kelas = '$kelas'
    ORDER BY siswa.nama");

$l_absen = [];
foreach ($siswa as $row) {
    $nis = $row['nis'];
    $l_absen[$nis] = [
        'nama' => $row['nama'],
        'kehadiran' => array_fill(1, $jumlah_hari, ''),
    ];
}

foreach ($presensi as $row) {
    $nis = $row['nis'];
    $tgl = (int)substr($row['tgl'], -2); // Ambil tanggal (hari) dari tgl
    $l_absen[$nis]['kehadiran'][$tgl] = $row['ket'];
};

?>
<script src="https://cdn.tailwindcss.com"></script>

    <div class="relative overflow-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left" id="table" border="1" >
            <tr class="text-xs text-gray-700 uppercase bg-gray-50 divide-x divide-gray-300">
                <th class="px-3 py-1"></th>
                <th class="px-3 py-1">NIS</th>
                <th class="px-3">NAMA</th>
                <?php for ($i = 1; $i <= $jumlah_hari; $i++) : ?>
                    <th class="px-3"><?= $i ?></th>
                    <?php endfor; ?>
                <th class="px-3">HADIR</th>
                <th class="px-3">MENSETSU</th>
                <th class="px-3">IZIN</th>
                <th class="px-3">SAKIT</th>
                <th class="px-3">ALPHA</th>
            </tr>
            <?php $no = 1; ?>
            <?php foreach ($l_absen as $nis => $data) : 
            $hadir = 0;
            $mensetsu = 0;
            $izin = 0;
            $sakit = 0;
            $alpha = 0;
                foreach ($data['kehadiran'] as $kehadiran) :
                    
                    switch ($kehadiran) {
                        case 'H':
                            $hadir++;
                            break;
                        case 'M':
                            $mensetsu++;
                            break;
                        case 'I':
                            $izin++;
                            break;
                        case 'A':
                            $alpha++;
                            break;
                        case 'S':
                            $sakit++;
                            break;
                    }
                endforeach;
                ?>
                <tr class="dark:bg-slate-100 odd:bg-white border-b border-gray-200 divide-x divide-gray-300">
                    <td class="px-3 py-1"><?= $no++ ?></td>
                    <td class="px-3 py-1"><?= $nis ?></td>
                    <td class="px-3 py-1 "><?= $data['nama'] ?></td>
                    <?php foreach ($data['kehadiran'] as $kehadiran) : ?>
                        <td class="px-3"><?= $kehadiran ?></td>
                    <?php endforeach; ?>
                    <td class="px-3"><?= $hadir ?></td>
                    <td class="px-3"><?= $mensetsu ?></td>
                    <td class="px-3"><?= $izin ?></td>
                    <td class="px-3"><?= $sakit ?></td> 
                    <td class="px-3"><?= $alpha ?></td> 
                </tr>
            <?php endforeach; ?>
            </table>
    </div>
