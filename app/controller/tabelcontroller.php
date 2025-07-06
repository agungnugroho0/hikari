<?php
namespace app\controller;
use app\model\table;

class tabelcontroller{
    private $db;

    public function __construct(){
        $this->db = new table();
    }

    public function tabelexportexcel(){
        header('Content-Type: text/html; charset=utf-8');
        $bulan = $_GET['bulan']??date('Y-m');
        $kelas = $_GET['kelas']??'A';
        $siswa = $this->db->siswa($kelas);
        $presensi = $this->db->presensi($bulan,$kelas);
        $bln = substr($bulan,-2);
        $thn = substr($bulan,0,4);
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN,$bln,$thn);
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

echo '<script src="https://cdn.tailwindcss.com"></script>

    <div class="relative overflow-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left" id="table" border="1" >
            <tr class="text-xs text-gray-700 uppercase bg-gray-50 divide-x divide-gray-300">
                <th class="px-3 py-1"></th>
                <th class="px-3 py-1">NIS</th>
                <th class="px-3">NAMA</th>';
                for ($i = 1; $i <= $jumlah_hari; $i++) :
                    echo '<th class="px-3">'.$i.' </th>';
                    endfor; 
                echo '<th class="px-3">HADIR</th>
                <th class="px-3">MENSETSU</th>
                <th class="px-3">IZIN</th>
                <th class="px-3">SAKIT</th>
                <th class="px-3">ALPHA</th>
            </tr>';
            $no = 1;
            foreach ($l_absen as $nis => $data) : 
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
                endforeach ; 
                echo
                '<tr class="dark:bg-slate-100 odd:bg-white border-b border-gray-200 divide-x divide-gray-300">
                    <td class="px-3 py-1">'.$no++.'</td>
                    <td class="px-3 py-1">'.$nis.'</td>
                    <td class="px-3 py-1 ">'.$data['nama'].'</td>';
                    foreach ($data['kehadiran'] as $kehadiran) :
                        echo '<td class="px-3">'.$kehadiran.'</td> ';
                    endforeach;
                    echo '<td class="px-3">'.$hadir.'</td>';
                    echo '<td class="px-3">'.$mensetsu.'</td>';
                    echo '<td class="px-3">'.$izin.'</td>';
                    echo '<td class="px-3">'.$sakit.'</td>'; 
                    echo '<td class="px-3">'.$alpha.'</td>
                </tr>';
                endforeach;
            echo '</table>
    </div>';
    }
}