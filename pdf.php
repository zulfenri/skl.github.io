<?php
  require_once("tcpdf/tcpdf.php");
  //require_once('tcpdf/tcpdf_include.php');



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Gading Creation');
$pdf->setTitle('Documen Cust');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$pdf->setFont('Times', '', 11, '', true);
$pdf->setprintheader(false);
$pdf->AddPage();

$html = file_get_contents("http://localhost/pdf/new_html.php?nisn=123&npsn=10306090");

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('SKL.pdf', 'I');


?>