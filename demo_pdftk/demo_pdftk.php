<?php
if(!isset($_POST['lis_person_name_full'])){
    $NAME="Lord Jabberwoky Pubert Throckmorton IV";
}else{
    $NAME=$_POST['lis_person_name_full'];
}

// set up temp file names
$FDFfile = tempnam(sys_get_temp_dir(), gethostname());
$PDFfile = tempnam(sys_get_temp_dir(), gethostname());

// build our FDF data file string
// bring in top part of FDF file
$dataFile = file_get_contents("../file_parts/cert_form_header.fdf");

// insert our participants name in the right spot
$dataFile .= "<< /T (Text Box 1) /V (".$NAME.") >> \n";

// date printed
$dataFile .= "<< /T (Text Box 2) /V (" . date("jS \of F Y", time()) . ") >> \n";
// finish the FDF file
$dataFile .= file_get_contents("../file_parts/cert_form_footer.fdf");

// put the FDF data into the tempfile
file_put_contents($FDFfile, $dataFile);

// use pdftk to merge data/pdf form and then
// flatten to prevent editing 
exec("pdftk ../file_parts/cert_form.pdf fill_form " . $FDFfile . " output " . $PDFfile . " flatten");
// // if you have a PDf of a border pattern, or a signature, or whatever, you can
// use pdftk to "stamp" the contents of one pdf onto the other. do this AFTER
// you use pdftk to fill_form and flatten
// exec("pdftk " . $PDF1 . " stamp " . $PDF2 . " output " . $NewPDFfile);

// send final pdf file to browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename=certificate.pdf');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($PDFfile));
readfile($PDFfile);

// get rid of temp files
unlink($FDFfile);
unlink($PDFfile);
exit;
?>
