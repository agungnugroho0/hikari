<?php
function kuitansi($id_tx,$tabel){
    koneksi();
    require dirname(__DIR__)."/api/tcpdf/tcpdf.php";
    ob_end_clean(); 
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('LPK HIKARI');
    $pdf->SetTitle('TCPDF KUITANSI');
    $pdf->SetSubject('TCPDF KUITANSI');
    $pdf->SetKeywords('KUITANSI');
        
    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // set default monospaced font
    $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    
    // set auto page breaks
    $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);
    $kuitansi = tampil("SELECT log_pembayaran.*,$tabel.nis,$tabel.nama FROM log_pembayaran JOIN $tabel ON log_pembayaran.nis = $tabel.nis WHERE log_pembayaran.id_tx = '$id_tx'");
    foreach($kuitansi as $v){
        $nama = $v['nama'];
        $tgl_bayar = $v['tgl_bayar'];
        $ket_bayar = $v['ket_bayar'];
        $jumlah = number_format($v['jumlah'],0,".",",");
        $kekurangan = number_format($v['kekurangan'],0,".",",");
    }
    $pdf->Image('../../public/image/asset/kuitansi.jpg', 6,7, 197.534,69.25, 'JPG', '', '', false, 200, '', false, false, 0, false, false, false);
    $pdf->setXY(166,9.7);
    $pdf->Cell(123,8,$id_tx,0,1,'L');
    $pdf->setXY(68,24);
    $pdf->Cell(121,6,$tgl_bayar,0,1,'L');
    $pdf->setXY(68,32);
    $pdf->Cell(121,6,$nama,0,1,'L');
    $pdf->setXY(68,39.6);
    $pdf->Cell(121,6,"Rp. ".$jumlah,0,1,'L');
    $pdf->setXY(68,47.3);
    $pdf->Cell(121,6,$ket_bayar,0,1,'L');
    $pdf->setXY(68,55.7);
    $pdf->Cell(121,6,"Rp. ".$kekurangan,0,1,'L');
    return $pdf->Output($nama.'.pdf', 'D');

}