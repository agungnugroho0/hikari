<?php

require '../../autoloader.php';


header('Content-Type: application/json'); // Aktifkan kembali header json

function stringToColor($str) {
  $code = dechex(crc32($str));
  return '#' . substr($code, 0, 6);
}

$wawancara = tampil("SELECT 
  job.id_job AS id_job,
  job.tgl_job AS start_datetime,
  IF(
    job.tgl_job IS NULL 
    OR job.tgl_job + 0 = 0, 
    NULL, 
    DATE_ADD(job.tgl_job, INTERVAL 23 HOUR)
  ) AS end_datetime,
  so.so AS nama_so,
  job.job AS nama_job,
  CASE
    WHEN job.tgl_job IS NULL 
         OR job.tgl_job + 0 = 0
    THEN 'Belum Dijadwalkan'
    ELSE 'Sudah Dijadwalkan'
  END AS status
FROM job
LEFT JOIN so ON job.id_so = so.id_so
ORDER BY status, job.tgl_job;");

$data_chart = [];

foreach ($wawancara as $row) {
    $color = stringToColor($row['nama_so']);
    $start = strtotime($row['start_datetime'] ?? '');
    $end   = strtotime($row['end_datetime'] ?? '');

    if (!$start || !$end) {
        // Job belum dijadwalkan
        $now = time() * 1000;
        $dummy_end = $now + 58000000; // +5 jam

        $data_chart[] = [
            "x" => $row['nama_so'].  " #" . $row['id_job'],
            "y" => [$now, $dummy_end],
            "status" => 'Belum Dijadwalkan',
            // "nama_job" => $row['nama_job'],
            "fillColor" => '#000000',
        ];
    } else {
        // Job sudah dijadwalkan
        $data_chart[] = [
            "x" => $row['nama_so'].  " #" . $row['id_job'],
            "y" => [$start * 1000, $end * 1000],
            "status" => 'Sudah Dijadwalkan',
            // "nama_job" => $row['nama_job'],
            "fillColor" => $color,
        ];
    }
}


echo json_encode($data_chart);
