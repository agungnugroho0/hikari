<?php

namespace app\controller;
use app\model\grafik;

class grafikcontroller{
    public function lolosperbulan(){
        $bulan = $_GET['bulan']??date('Y-m');
        $model = new grafik();
        $data = $model->grafikjmllolosperbulan($bulan);
        header ('Content-Type: application/json');
        echo json_encode($data);
    }
    public function lolosperkelas(){
        $bulan = $_GET['bulan']??date('Y-m');
        $kelas = $_GET['kelas']??'A';
        $model = new grafik();
        $data = $model->grafikjmllolosperkelas($kelas,$bulan);
        header ('Content-Type: application/json');
        echo json_encode($data);
    }

    public function jadwalmensetsucontroller(){
    // $model = new grafik();
    // $data = $model->grafikjadwalmensetsu();

    // function stringToColor($str) {
    //     $code = dechex(crc32($str));
    //     return '#' . substr($code, 0, 6);
    // }

    // $data_chart = [];

    // foreach ($data as $row) {
    //     $color = stringToColor($row['nama_so']);
    //     $start = $row['start_ts'];
    //     $end = $row['end_ts'];

    //     if (!$start || !$end) {
    //         $now = time() * 1000;
    //         $dummy_end = $now + 2 * 60 * 60 * 1000;

    //         $data_chart[] = [
    //             "x" => $row['nama_so'] . " #" . $row['id_job'],
    //             "y" => [$now, $dummy_end],
    //             "status" => 'Belum Dijadwalkan',
    //             "nama_job" => $row['nama_job'],
    //             "fillColor" => '#000000',
    //         ];
    //     } else {
    //         $data_chart[] = [
    //             "x" => $row['nama_so'] . " #" . $row['id_job'],
    //             "y" => [$start, $end],
    //             "status" => date('d M Y H:i', $start / 1000),
    //             "nama_job" => $row['nama_job'],
    //             "fillColor" => $color,
    //         ];
    //     }
    // }

    $model = new grafik();
    $data = $model->grafikjadwalmensetsu();

    function stringToColor($str) {
        $code = dechex(crc32($str));
        return '#' . substr($code, 0, 6);
    }

    $data_chart = [];

    foreach ($data as $row) {
        $color = stringToColor($row['nama_so']);

        if (empty($row['tgl_job'])) {
            $data_chart[] = [
                "title" => $row['nama_job'] . " (Belum Dijadwalkan)",
                "start" => date('Y-m-d'),
                "status" => "Belum Dijadwalkan",
                "so" => $row['nama_so'],
                "backgroundColor" => "#999999",
                "nama_job" => $row['nama_job'],
            ];
        } else {
            $data_chart[] = [
                "title" => $row['nama_job'] . " ( " . $row['nama_so'] . " )",
                "start" => $row['tgl_job'],
                "status" => "Sudah Dijadwalkan",
                "so" => $row['nama_so'],
                "backgroundColor" => $color,
                "nama_job" => $row['nama_job'],
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data_chart);
}

    public function grafikabsendashboard(){
        $bulan = $_GET['bulan']??date('Y-m');
        $kelas = $_GET['kelas']??'A';
        $model = new grafik();
        $data = $model->grafikabsenperkelas($kelas,$bulan);
        header('Content-Type: application/json');
        echo json_encode($data);

    }

    public function grafikabsenlaporan(){
        $bulan = $_GET['bulan']??date('Y-m');
        $kelas = $_GET['kelas']??'A';
        $model = new grafik();
        $id_kelas = $model->pilihkelas($kelas)['id_kelas'];
        $data = $model->grafikabsenperkelas($id_kelas,$bulan);
        header('Content-Type: application/json');
        echo json_encode($data);
    }


}