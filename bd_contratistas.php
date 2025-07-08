<?php

require ('config/config.php');

ini_set('date.timezone','America/Santiago'); 
$hora=date("H-i-s");

 function make_date(){
        return strftime("%d-%m-%Y", time());
 }
 $fecha =make_date();

$Name = 'DB_contratistas_'.$fecha.'_'.$hora.'.csv';
$FileName = "./$Name";
$Datos = 'Mandante;Contratista;Documento;Fecha;Estado';
$Datos .= "\r\n";

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.basename($Name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($Name));
        

$query=mysqli_query($con,"select m.doc_contratista, m.creado as fecha, c.razon_social as nom_contratista, c.habilitada, a.razon_social as nom_mandante from contratistas_mandantes as m Left Join contratistas as c On c.id_contratista=m.contratista Left Join mandantes as a On a.id_mandante=m.mandante where m.acreditada=1 order by c.razon_social asc  ");

$i=1;

foreach ($query as $oRow) {

    switch ($oRow['habilitada']) {
      case  '0':$habilitada='HABILITADA';break;
      case  '1':$estado_t='DESHABILITADA';break;
    }

    switch ($oRow['acreditada']) {
      case  '0':$acreditada='ACREDITADA';break;
      case  '1':$acreditada='NO ACREDITADA';break;
    }

    $dia=substr($oRow['fecha'],8,2);
    $mes=substr($oRow['fecha'],5,2);
    $ano=substr($oRow['fecha'],0,4);
    $fecha=$dia.'-'.$mes.'-'.$ano;
    $documentos=unserialize($oRow['doc_contratista']);
    foreach ($documentos as $row) {
        $query_d=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$row."' ");
        $result_d=mysqli_fetch_array($query_d);
        $Datos .= $oRow['nom_mandante'].";".$oRow['nom_contratista'].";".$result_d['documento'].";".$fecha.";".$habilitada;
        $Datos .= "\r\n"; 
        $i=$i+1;        
    }    
}   
 
echo $Datos;

 


?>