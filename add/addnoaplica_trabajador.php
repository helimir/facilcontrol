<?php
session_start();
if (isset($_SESSION['usuario']) ) { 

include('../config/config.php');
include('../fpdf/fpdf.php');
date_default_timezone_set('America/Santiago');
function make_date(){
        return strftime("%Y-%m-%d H:m:s", time());
 }
$fecha =make_date();
$date = date('Y-m-d H:m:s', time());

$perfil=$_SESSION['perfil'];
$cargo=$_SESSION['cargo'];
 
$contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
$mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
$contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';
$trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
$doc=isset($_POST['doc']) ? $_POST['doc']: ''; 
$mensaje_na=isset($_POST['mensaje']) ? $_POST['mensaje']: '';
$rut=isset($_POST['rut']) ? $_POST['rut']: '';

$query_guardar=mysqli_query($con,"insert into noaplica_trabajador (contratista,mandante,documento,mensaje,contrato,trabajador) values ('$contratista','$mandante','$doc','$mensaje_na','$contrato','$trabajador') ");

if ($query_guardar) {

    #datos de la contratista
    $query_contratista=mysqli_query($con,"select o.nombre_contrato, c.razon_social as contratista, m.razon_social as mandante, c.rut, m.rut_empresa from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratos as o On o.contratista=c.id_contratista where c.id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);

    #datos del trabajador    
    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' ");
    $result_t=mysqli_fetch_array($query_t);
    $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];

    $query_doc=mysqli_query($con,"select * from doc where id_doc='$doc'  ");
    $result_doc=mysqli_fetch_array($query_doc);
    $documento=$result_doc['documento']; 

    $nom_contratista=$result_contratista['contratista'];
    $nom_mandante=$result_contratista['mandante'];
    $nom_contrato=$result_contratista['nombre_contrato'];

    // notificacion que falta perfiles. accion. control: nombre del documento
    $item='Documento Trabajador No Aplica';                 
    $nivel=3;
    $tipo=2;
    $envia=$contratista;
    $recibe=$_SESSION['mandante'];
    $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$documento</b> del trabajador <b>$nom_trabajador</b>, contrato <b>$nom_contrato</b>, indicando que no aplica.";
    $mensaje2="El contratista $nom_contratista envio el documento $documento del trabajador $nom_trabajador, contrato $nom_contrato, indicando que no aplica.";
    $usuario=$_SESSION['usuario'];
    $accion="Revisar documento de trabajador";
    $url="verificar_documentos_trabajador_mandante.php";
                         
 
    $query_na=mysqli_query($con,"select id_na from noaplica_trabajador where contrato='$contrato' and trabajador='$trabajador' and documento='$doc' ");
    $result_na=mysqli_fetch_array($query_na);
    $no_aplica=$result_na['id_na'];

    
    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and contrato='$contrato' and trabajador='$trabajador' and control='$documento' and tipo='2'  ");
    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,perfil,cargo,trabajador,documento,id_noaplica) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$documento','$contrato','$perfil','$cargo','$trabajador','$doc','$no_aplica') ");
    mysqli_query($con,"update trabajadores_asignados set verificados=2, editado='$date' where trabajadores='$trabajador' and contrato='$contrato' ");
    mysqli_query($con,"update comentarios set estado=1, leer_mandante=1, leer_contratista=1, editado='$date' where trabajador='$trabajador' and contrato='$contrato' and doc='$documento' ");
                 
    $nombre=$documento.'_'.$rut.'.pdf';
    $url='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$nombre;        

    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $trabajador_nom=$nom_trabajador.'-'.$rut;

    class PDF extends FPDF {

        function Header() {
            $this->Image('../assets/img/logo_fc.png',10,10,40,20);
            $this->SetFont('Arial','B',14);
            $this->SetXY(55,20);
            $this->Cell(0,6,'Documento Vehiculo No Aplica ',0,0,'L',false);     
        
            $this->Ln(15);
        }
    
        function mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento,$trabajador_nom) {
           
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


            $this->SetXY(10,45);
            $this->SetFont('Arial','B',10);        
            $this->MultiCell(0,4,'Trabajador: ',0,'L',false);
            $this->SetXY(35,45);
            $this->SetFont('Arial','',10);     
            $this->MultiCell(0,4,utf8_decode($trabajador_nom),0,'L',false);
            
            $this->SetXY(10,55);
            $this->SetFont('Arial','B',10);
            $this->MultiCell(0,4,'Documento: ',0,'L',false);
            $this->SetXY(10,60);
            $this->SetFont('Arial','',10);
            $this->MultiCell(0,4,utf8_decode($documento),0,'L',false);
            
            $this->SetXY(10,70);
            $this->SetFont('Arial','B',10);
            $this->MultiCell(0,4,'Mensaje: ',0,'L',false);
            $this->SetXY(10,75);
            $this->SetFont('Arial','',10);
            $this->MultiCell(0,4,utf8_decode($mensaje_na),0,'J',false);
    
        }
    }
        
    
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento,$trabajador_nom);
    #$pdf->Output('I','no_aplica.pdf'); 
    $pdf->Output('F',$carpeta.$documento.'_'.$rut.'.pdf');
        
    echo 0 ;



} else {
    echo 1;
}
    
} else { 

    echo '<script> window.location.href="admin.php"; </script>';
    }  

?>