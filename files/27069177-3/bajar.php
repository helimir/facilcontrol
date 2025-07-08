<?php

/**
 * @author Christian 
 * @copyright 2021
 */

$rut=$_GET['rut'];
//$rut='26342101-9';

$files = array("
4x4_$rut.pdf",
"cc_$rut.pdf",
"foto_$rut.jpg",
"cesso_$rut.pdf",
"ci_$rut.pdf",
"contrato_$rut.pdf",
"huc_$rut.pdf",
"licencia_$rut.pdf",
"odi_$rut.pdf",
"psico_$rut.pdf",
"rihs_$rut.pdf",
"sust_$rut.pdf",
"defe_$rut.pdf",
"ocupa_$rut.pdf",
"extra_$rut.pdf",
"erihs_$rut.pdf",
"eodi_$rut.pdf",
"epp_$rut.pdf",
"acontrato_$rut.pdf",
"finiquito_$rut.pdf",
"pcontrato_$rut.pdf",
"competencia_$rut.pdf");
$zipname = "ficha_$rut.zip";
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
     $zip->addFile($file);
}
$zip->close();


header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
//header('Content-Length: ' . filesize($zipname));
readfile($zipname);

?>