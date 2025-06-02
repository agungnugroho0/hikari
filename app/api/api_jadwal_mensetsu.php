<?php

require '../../autoloader.php';

// ini_set('display_errors', 1);
error_reporting(E_ALL);
// file_put_contents('/tmp/mensetsu_debug.txt', "Masuk API Mensetsu\n", FILE_APPEND);

// header('Content-Type: application/json'); // Aktifkan kembali header json
echo "tes";
// echo json_encode($data); // Aktifkan kembali json_encode
// function stringToColor($str) {
//   $code = dechex(crc32($str));
//   return '#' . substr($code, 0, 6);
// }

// $wawancara = tampil("SELECT
//   ANY_VALUE(job.id_job) AS id_job,
//   job.tgl_job AS start_datetime,
//   IF(job.tgl_job IS NULL OR job.tgl_job = '0000-00-00', NULL, DATE_ADD(job.tgl_job, INTERVAL 24 HOUR)) AS end_datetime,
//   so.so AS nama_so,
//   COUNT(job.id_job) AS jumlah_job,
//   CASE
//     WHEN job.tgl_job IS NULL OR job.tgl_job = '0000-00-00' THEN 'Belum Dijadwalkan'
//     ELSE 'Sudah Dijadwalkan'
//   END AS status
// FROM job
// JOIN so ON job.id_so = so.id_so
// GROUP BY so.so, job.tgl_job
// ORDER BY FIELD(status, 'Belum Dijadwalkan', 'Sudah Dijadwalkan'), job.tgl_job");

// $data_chart = [];

// foreach ($wawancara as $row) {
//     $color = stringToColor($row['nama_so']);

//     $start = strtotime($row['start_datetime'] ?? '');
//     $end   = strtotime($row['end_datetime'] ?? '');

//     // Kalau tanggal invalid (NULL/0000-00-00), pakai waktu dummy
//     if (!$start || !$end) {
//         $now = time() * 1000;
//         $dummy_end = $now + 18000000; // +5 jam

//         $data_chart[] = [
//             "x" => substr($row['nama_so'], 0, 10),
//             "y" => [$now, $dummy_end],
//             "fillColor" => '#000000',
//             "jumlah_job" => 'Belum Dijadwalkan'
//         ];

//         file_put_contents('/tmp/mensetsu_debug.txt', "Datetime error: ".json_encode($row)."\n", FILE_APPEND);
//         continue;
//     }

//     // Jika tanggal valid
//     $data_chart[] = [
//         "x" => substr($row['nama_so'], 0, 10),
//         "y" => [$start * 1000, $end * 1000],
//         "status" => 'Sudah Dijadwalkan',
//         "jumlah_job" => $row['jumlah_job'],
//         "fillColor" => $color,
//     ];
// }


// echo json_encode($data_chart);
