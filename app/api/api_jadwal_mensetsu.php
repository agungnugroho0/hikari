<?php
header('Content-Type: application/json');
// require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
require '../../autoloader.php';

function stringToColor($str) {
  $code = dechex(crc32($str));
  return '#' . substr($code, 0, 6);
};

$wawancara = tampil ("SELECT
  job.id_job,
  job.tgl_job AS start_datetime,
  IF(job.tgl_job = '0000-00-00', NULL, DATE_ADD(job.tgl_job, INTERVAL 12 HOUR)) AS end_datetime,
  so.so AS nama_so, COUNT(job.id_job) AS jumlah_job,
  CASE
    WHEN job.tgl_job = '0000-00-00' THEN 'Belum Dijadwalkan'
    ELSE 'Sudah Dijadwalkan'
  END AS status
FROM job
JOIN so ON job.id_so = so.id_so GROUP BY so.so, job.tgl_job
ORDER BY FIELD(status, 'Belum Dijadwalkan', 'Sudah Dijadwalkan'), job.tgl_job");

$data_chart = [];

foreach ($wawancara as $row) {

  $color = stringToColor($row['nama_so']); // generate warna unik berdasarkan nama SO
    // Kalau belum dijadwalkan, kasih waktu dummy biar bisa tetap muncul
    if ($row['start_datetime'] == '0000-00-00' || !$row['end_datetime']) {
        $now = time() * 1000;
        $dummy_end = $now + 18000000; // Tambah 1 menit
        $data_chart[] = [
            "x" => substr($row['nama_so'], 0, 10), // ambil 10 karakter pertama dari nama_so
            "y" => [$now, $dummy_end],
            "fillColor" => '#000000', // warna abu-abu
            "jumlah_job" => 'Belum Dijadwalkan'
        ];
    } else {
        $data_chart[] = [
            "x" => substr($row['nama_so'], 0, 10),
            "y" => [
                strtotime($row['start_datetime']) * 1000,
                strtotime($row['end_datetime']) * 1000
            ],
            "status" => 'Sudah Dijadwalkan',
            "jumlah_job" => $row['jumlah_job'],
            "fillColor" => $color, // warna unik berdasarkan nama SO
        ];
    }
}

echo json_encode($data_chart);
