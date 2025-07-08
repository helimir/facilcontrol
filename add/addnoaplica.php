<?php
include('../config/config.php');
include('../fpdf/fpdf.php');
date_default_timezone_set('America/Santiago');
function make_date(){
        return strftime("%Y-%m-%d H:m:s", time());
 }
$fecha =make_date();
$date = date('Y-m-d H:m:s', time());
 
$contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
$mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
$doc=isset($_POST['doc']) ? $_POST['doc']: ''; 
$mensaje_na=isset($_POST['mensaje']) ? $_POST['mensaje']: '';

$query_guardar=mysqli_query($con,"insert into noaplica (contratista,mandante,documento,mensaje) values ('$contratista','$mandante','$doc','$mensaje_na') ");

if ($query_guardar) {

    $query_contratista=mysqli_query($con,"select c.razon_social as contratista, m.razon_social as mandante, c.rut, m.rut_empresa from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where c.id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);

    $query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$doc'  ");
    $result_doc=mysqli_fetch_array($query_doc);

    

    $documento=$result_doc['documento'];
    $id_doc=$result_doc['id_cdoc'];
    $nom_contratista=$result_contratista['contratista'];
    $nom_mandante=$result_contratista['mandante'];
    $rut_contratista=$result_contratista['rut'];
    $rut_mandante=$result_contratista['rut_empresa'];

    $query_subidos=mysqli_query($con,"select * from doc_subidos_contratista where contratista='$contratista' and mandante='$mandante' and documento='$documento'  ");
    $result_subidos=mysqli_fetch_array($query_subidos);

    // notificacion que falta perfiles. accion. control: nombre del documento
    $item='Documento No Aplica';                 
    $nivel=3;
    $tipo=1;
    $envia=$contratista;
    $recibe=$_SESSION['mandante']; 
    $mensaje="El contratista <b>$nom_contratista</b> indica que el <b>$documento</b> no aplica.";
    $mensaje2="El contratista $nom_contratista indica que el $documento no aplica.";
    $usuario=$_SESSION['usuario'];
    $accion="Revisar documento de contratista";
    $url="gestion_documentos_contratistas.php"; 
 
    $query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and documento='".$doc."' ");
    $result_na=mysqli_fetch_array($query_na);
    $no_aplica=$result_na['id_na'];

    
    $url_noaplica='doc/temporal/'.$mandante.'/'.$contratista.'/'.$documento.'_'.$rut_contratista.'.pdf';
    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and control='$documento' and item='Documento Recibido' ");
    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and control='$documento' and item='Observacion de Documento' ");
    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and documento='$documento'  ");
    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,id_noaplica) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$documento','$documento','$no_aplica') ");
    mysqli_query($con,"delete from doc_comentarios where doc='$documento' and contratista='$contratista' and mandante='$mandante' ");
    
    #borrar documento subidos
    mysqli_query($con,"delete from doc_subidos_contratista where documento='$documento' and  contratista='$contratista' and mandante='$mandante' ");
    mysqli_query($con,"insert into doc_subidos_contratista (documento,contratista,mandante,url,id_documento,creado,noaplica) values ('$documento','$contratista','$mandante','$url_noaplica','$id_doc','$date','1') ");    
              
    $nombre=$result_doc2['documento'].'_'.$result_contratista['rut'].'.pdf';
    $url='doc/temporal/'.$mandante.'/'.$contratista.'/'.$nombre;            
  
    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    class PDF extends FPDF {

        function Header() {
            $this->Image('../assets/img/logo_fc.png',10,10,40,20);
            $this->SetFont('Arial','B',14);
            $this->SetXY(55,20);
            $this->Cell(0,6,'Documento Contratista No Aplica',0,0,'L',false);     
        
            $this->Ln(15);
        }
    
        function mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento) {
           
            $this->SetFont('Arial','B',10);        
            $this->MultiCell(0,4,'Contratista: ',0,'L',false);
    
            $this->SetXY(35,35);
            $this->SetFont('Arial','',10);     
            $this->MultiCell(0,4,utf8_decode($nom_contratista),0,'L',false);
    
            $this->SetXY(10,40);
            $this->SetFont('Arial','B',10);        
            $this->MultiCell(0,4,'Mandante: ',0,'L',false);
            $this->SetXY(35,40);
            $this->SetFont('Arial','',10);     
            $this->MultiCell(0,4,utf8_decode($nom_mandante),0,'L',false);
            
            $this->SetXY(10,50);
            $this->SetFont('Arial','B',10);
            $this->MultiCell(0,4,'Documento: ',0,'L',false);
            $this->SetXY(10,55);
            $this->SetFont('Arial','',10);
            $this->MultiCell(0,4,utf8_decode($documento),0,'L',false);
            
            $this->SetXY(10,65);
            $this->SetFont('Arial','B',10);
            $this->MultiCell(0,4,'Mensaje: ',0,'L',false);
            $this->SetXY(10,70);
            $this->SetFont('Arial','',10);
            $this->MultiCell(0,4,utf8_decode($mensaje_na),0,'J',false);
    
        }
    }
        
    
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento);
    #$pdf->Output('I','no_aplica.pdf'); 
    $pdf->Output('F',$carpeta.$documento.'_'.$rut_contratista.'.pdf');
        
    echo 0 ;



} else {
    echo 1;
}
    
    
    

?>