<?php

require('../libfpdm/fpdm.php'); 

// set up temp file names
$FDFfile = tempnam(sys_get_temp_dir(), gethostname());
$PDFfile = tempnam(sys_get_temp_dir(), gethostname());

// build our FDF data file string
// bring in top part of FDF file
$dataFile = file_get_contents("../file_parts/cert_form_header.fdf");
// insert our participants name in the right spot
$dataFile .= "<< /T (Text Box 1) /V (Willheim Jabberwocky Throckmorton III) >> \n";
$dataFile .= "<< /T (Text Box 2) /V (" . date("jS \of F Y", time()) . ") >> \n";
// finish the FDF file
$dataFile .= file_get_contents("../file_parts/cert_form_footer.fdf");
// put file contents into disk 
file_put_contents($FDFfile, $dataFile);

// build full file path to template
// FPDM has issues with relative paths the way i've moved it around
$basePath=$_SERVER['DOCUMENT_ROOT'];
$basePath.=dirname($_SERVER['PHP_SELF']);

// call FPDM
$pdf = new FPDM($basePath.'/../file_parts/cert_form.pdf',$FDFfile);

$pdf->Merge();
$pdf->Flatten();
$pdf->Output();
exit;
?>
