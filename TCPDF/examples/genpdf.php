<?php

use MYPDF as GlobalMYPDF;

    include('koneksi.php');
    $nisn=$_GET['ni'];
    $npsn=$_GET['np'];
    if(isset($nisn, $npsn)) 
    { 
        $koneksi = mysqli_connect($host,$user,$pass,$db); }
    
    if(isset($nisn, $npsn)) 
    {
        $query = mysqli_query($koneksi,"select * from siswa where nisn='".$nisn."'");
        $row = mysqli_fetch_array($query);
        header("Content-type: " . $row["tipe_gambar"]);
    }
    else
    {
        header('location:genpdf.php');
    }    
    //tabel siswa
    $qsis = mysqli_query($koneksi,'select * from siswa where nisn='.$nisn.' and npsn='.$npsn);
    $R_Sis= mysqli_fetch_array($qsis);
    
    //tabel sekolah
    $qsek = mysqli_query($koneksi,'select * from sekolah where npsn='.$npsn);
    $R_Sek= mysqli_fetch_array($qsek);
    
    //tabel nilai
    $qnilai = mysqli_query($koneksi,'select * from nilai where nisn='.$nisn.' and npsn='.$npsn);
    //$R_Nilai= mysqli_fetch_array($qnilai);
    //Rata-rata nilai
    $qAvg = mysqli_query($koneksi,'select AVG(nilai) as R from nilai where nisn='.$nisn.' and npsn='.$npsn);
    $AVG= mysqli_fetch_array($qAvg);
    $Rata= number_format($AVG['R'],2,',','.');

    require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'skl.JPG';
        $this->Image($image_file, 8, 10, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('times', 'B', 11);
        // Title
        $this->Cell(163, 5, 'YAYASAN AGUS SUSANTO NASUTION', 0, 1, 'C');
        $this->SetFont('TIMES', 'B', 11);
        $this->Cell(189, 3, 'SMK S IT AGUS SUSANTO', 0, 1, 'C');
        $this->Cell(189, 3, 'DINAS PENDIDIKAN PROVINSI SUMATERA BARAT', 0, 1, 'C');
        $this->SetFont('TIMES', '', 9);
        $this->Cell(189, 3, 'Jalan Flores Kuamang Ujung Gading', 0, 1, 'C');    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Download from SKL Online |Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}    
    // create new PDF document
    $pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Zulfenri');
    $pdf->SetTitle('Surat Keterangan Kelulusan Online');
    $pdf->SetSubject('Surat Keterangan Kelulusan');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);   
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 11);

    // add a page
    $pdf->AddPage();
    //Membuat Line
    $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
    $style2 = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    $style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(0, 0, 0));
    $pdf->Line(8, 32, 200, 32, $style2);

    // create some HTML content
    $hjudul = '<br><br><div style=" text-align: center;"><u><span style="font-weight:bold;">Surat Keterangan Kelulusan</span></u> <br>
            < style=" text-align: center;">Nomor : 001/001010101</></div> <br>
            <p style="text-align:justify;">Saya yang bertanda tangan dibawah ini Kepala '.$R_Sek['sekolah'].', menerangkan bahwa :</p>';
    
    $hbio = '<table>
                <tr>
                    <td style="width:8%;height:6mm;"></td>
                    <td style="width:25%;height:6mm; text-align:left;">Nama</td>
                    <td style="width:50%;height:6mm;text-align:left;">: '.$R_Sis['nama'].'</td>
                </tr>                
                <tr>
                    <td style="width:8%;height:6mm;"></td>
                    <td style="width:25%;height:6mm; text-align:left;">Tempat/ Tanggal Lahir</td>
                    <td style="width:50%;height:6mm;text-align:left;">: '.$R_Sis['tptlhr'].'/ '.date('d F Y',strtotime($R_Sis['tgllhr'])).'</td>
                </tr>                
                <tr>
                    <td style="width:8%;height:6mm;"></td>
                    <td style="width:25%;height:6mm; text-align:left;">Nama Orang Tua/ Wali</td>
                    <td style="width:50%;height:6mm;text-align:left;">: '.$R_Sis['ortu'].'</td>
                </tr>                
                <tr>
                    <td style="width:8%;height:6mm;"></td>
                    <td style="width:25%;height:6mm; text-align:left;">NIS/ NISN</td>
                    <td style="width:50%;height:6mm;text-align:left;">: '.$R_Sis['nis'].'/ '.$R_Sis['nisn'].'</td>
                </tr>                
                <tr>
                    <td style="width:8%;height:6mm;"></td>
                    <td style="width:25%;height:6mm; text-align:left;">Nomor Ujian</td>
                    <td style="width:50%;height:6mm;text-align:left;">: '.$R_Sis['nopes'].'</td>
                </tr>                
             </table>
             <p style="text-align:justify;">Dengan ini dinyatakan
             <u><b>'.$R_Sis['statlulus'].'</b></u> dari '.$R_Sek['sekolah'].' dengan nilai sebagai berikut : </p>
             '; 
             
    $hpenutup = 
            '<p style="text-align:justify;">Demikianlah surat keterangan ini dibuat untuk dapat dipergunakan sebaik- baiknya.</p>
            <br>
            <table>
                <thead >
                    <tr>
                        <th style="width:60%;height:6mm;"></th>
                        <th style="width:40%;height:6mm;text-align:center;">'.$R_Sek['alamatsurat'].', '.date('d F Y',strtotime($R_Sek['tglsurat'])).'</th>
                    </tr>    
                    <tr>
                        <th style="width:60%;"></th>
                        <th style="width:40%;text-align:center;">Kepala Sekolah</th>
                    </tr> 
                    <tr>
                        <th style="width:60%;height:28mm;"><img src="" width="100"/></th>
                        <th style="width:40%;height:28mm;text-align:center;"></th>
                    </tr> 
                    <tr>
                        <th style="width:60%;"></th>
                        <th style="width:40%;text-align:center;"><b><u>'.$R_Sek['kepala'].'</u></b></th>
                    </tr> 
                    <tr>
                        <th style="width:60%;"></th>
                        <th style="width:40%;text-align:center;">NIP. '.$R_Sek['nip'].'</th>
                    </tr>
                </thead>    
            </table>
            ';

                    
             
    $html = $hjudul.'<br />'.$hbio.'<br />';

    $pdf->writeHTML($html, true, false, true, false, '');
   
//header tabel          
    $pdf->setFont('times','b','12');
    $pdf->Cell(15,9,'No',1,0,'C',0);
    $pdf->Cell(130,9,'Mapel',1,0,'C');
    $pdf->Cell(30,9,'Nilai',1,1,'C');
//isi tabel
    $pdf->setFont('times','','12');
    $j=1;
    while($r1= mysqli_fetch_assoc($qnilai)){ 
    $pdf->Cell(15,6,$j++,1,0,'',0);
    $pdf->Cell(130,6,$r1['mapel'],1,0,'');
    $pdf->Cell(30,6,$r1['nilai'],1,1,'C');

    }
//Footer tabel
    $pdf->setFont('times','b','12');
    $pdf->Cell(15,8,'',1,0,'',0);
    $pdf->Cell(130,8,'Rata - Rata Nilai',1,0,'C');
    $pdf->Cell(30,8, $Rata,1,1,'C');

    $pdf->setFont('times','','12');
    $pdf->writeHTML('<br>'.$hpenutup, true, false, true, false, '');

                    // new style
                    $style = array(
                        'border' => false,
                        'padding' => 0,
                        'fgcolor' => array(0,0,0),
                        'bgcolor' => false
                    );
                    // QRCODE,H : QR-CODE Best error correction
                    $pdf->write2DBarcode('123456789012345678', 'QRCODE,H', 15, 240, 25, 25, $style, 'N');
                    $pdf->setFont('times','','8');
                    $pdf->Text(10, 265, 'Digenerate melalui SKL Online');

                    // ---------------------------------------------------------


    //Close and output PDF document
    $pdf->Output('SKL Online_'.$R_Sis['nama'].'.pdf', 'd');
?>