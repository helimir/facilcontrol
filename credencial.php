<?php
session_start();
require('fpdf/fpdf.php');
include('config/config.php');
include('phpqrcode/qrlib.php');
//require('rotation.php');



$query=mysqli_query($con,"select m.id_mandante, t.nombre1, t.apellido1, t.rut, a.codigo, a.url_foto, a.validez, r.cargo as cargo_t, m.razon_social as nom_mandante, c.razon_social as nom_contratista, o.nombre_contrato from trabajadores_acreditados as a Left join contratos as o On o.id_contrato=a.contrato Left Join contratistas as c On c.id_contratista=a.contratista Left Join mandantes as m On m.id_mandante=a.mandante Left Join trabajador as t On t.idtrabajador=a.trabajador Left Join cargos as r On r.idcargo=a.cargo  where a.codigo='".$_GET['codigo']."' ");
$result=mysqli_fetch_array($query);

$query_m=mysqli_query($con,"select logo from mandantes where id_mandante='".$result['id_mandante']."' ");
$result_m=mysqli_fetch_array($query_m);
$logo=$result_m['logo'];
       
        class PDF extends FPDF {
            // Cabecera de p�gina
            function Header()
            {
                // Logo
                $this->Image('img/credencial_nueva.jpeg',7,5,100);
                $this->Image('img/crede2.jpg',110,5,100);               
                $this->Ln(6);
            }
            
            // Pie de p�gina
            function Footer()
            {
                // Posici�n: a 1,5 cm del final
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',6);
                // N�mero de p�gina
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }
            
           
        }
    
       
        
        
        // Creaci�n del objeto de la clase heredada
        $pdf = new PDF('L','mm',array(216,100));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        //$pdf->SetFont('Arial','',10);
        //$pdf->Cell(100,5,'Informacion del Pedido',0,0,'L');
        //$pdf->Ln(8);
        //$pdf->SetXY(40,5);
        //$pdf->SetFont('Courier','B',18);
        //$pdf->Cell(7,9,'www.facilcontrol.cl',0); #16214E        
        //$extension=substr('img/trabajadores/'.$_GET['contratista'].'/'.$result['rut'].'/foto_'.$result['rut'].'.jpg',-3);
        //$url='img/trabajadores/'.$_GET['contratista'].'/'.$result['rut'].'/foto_'.$result['rut'].'.'.$extension; 
        //$url='img/trabajadores/'.$_GET['contratista'].'/'.$result['rut'].'/foto_'.$result['rut'].'.'.$extension; 
        //$url='img/trabajadores/35/27069177-3/foto_27069177-3.png';
        
        $pdf->Image($result['url_foto'] ,83,9,20,26);
        if (!empty($logo)) {
           $pdf->Image($logo,10,7,17,15);
        } 
        
        //if ($logo!="") {
        //    $pdf->Image($logo,12,9,14,14);
        //} 
        //$pdf->RotatedImage('img/trabajadores/35/27069177-3/foto_27069177-3.jpg',11,9,36,26,45);
        
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B',7);
        $pdf->SetXY(30,13);
        $pdf->Cell(45,8,utf8_decode($result_m['logo']),0);
        $pdf->SetXY(25,21.5);
        $pdf->Cell(45,8,utf8_decode($result['nombre_contrato']),0);
        $pdf->SetXY(25,27.5);
        $pdf->Cell(45,8,utf8_decode($result['nom_mandante']),0);
        $pdf->SetXY(25,33);
        $pdf->Cell(45,8,utf8_decode($result['cargo_t']),0);
        $pdf->SetXY(25,39);
        $pdf->Cell(45,8,utf8_decode($result['nombre1']).' '.utf8_decode($result['apellido1']),0);
        $pdf->SetXY(25,45);
        $pdf->Cell(44.5,8,$result['rut'],0);
        $pdf->SetXY(28,50.5);
        $pdf->Cell(45,8,$result['validez'],0);
        #if ($result['fecha']=="0000-00-00") {
        #    $pdf->Cell(45,8,'Indefinido',0);
        #} else {
        #    $pdf->Cell(45,8,$result['fecha'],0);
        #}        
        $pdf->SetTextColor(22,33,78);
        $pdf->SetFont('Arial','B',40);
        $pdf->SetXY(130,28);
        $pdf->Cell(44.5,8,substr($result['codigo'],0,3),0);
        $pdf->SetXY(163,28);
        $pdf->Cell(44.5,8,substr($result['codigo'],-3),0);
        $pdf->SetTextColor(255,255,255);
        //$pdf->SetXY(6,21);
        //$pdf->Cell(45,21,'Validez: '.$result_fecha['fecha'],0);
        //$pdf->SetXY(6,24.5);
        //$pdf->Cell(45,24.5,'Contratista: '.utf8_decode($result_fecha['contratista']),0);
        //$pdf->SetXY(6,28);
        //$pdf->Cell(45,28,'Mandante: '.utf8_decode($result_fecha['mandante']),0);
        $carpeta='img/qr/trabajadores/'.$_GET['contrato'].'/'.$result['rut'].'/';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        //$pdf->SetFont('Arial','B',10);
        //$pdf->SetXY(6,35);
        //$pdf->Cell(45,35,'Codigo Verificacion:'.$Hash,0);            
        $link ='https://prueba.facilcontrol.cl/validar_qr.php?codigo='.$result['codigo'];
        
        $qr=$carpeta.'/qr_'.$result['rut'].'_'.$_GET['contrato'].'.png';
        QRcode::png($link,$qr,QR_ECLEVEL_L,10,2);
        $pdf->Image($qr,115,41,18,17);
        
        $pdf->Output('credencial_'.$result['rut'].'.pdf','I');

?>