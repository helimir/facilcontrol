<?php
session_start();
require('fpdf/fpdf.php');
include('config/config.php');
include('phpqrcode/qrlib.php');
//require('rotation.php');



$query=mysqli_query($con,"select c.contrato, c.url_foto, c.codigo, n.nombre_contrato, o.razon_social as nom_contratista, m.razon_social as nom_mandante, m.logo, a.tipo, a.marca, a.modelo, a.color, a.patente from autos as a Left Join vehiculos_acreditados as c On c.vehiculo=a.id_auto Left join contratistas as o On o.id_contratista=c.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratos as n On id_contrato=c.contrato where c.codigo='".$_GET['codigo']."' ");
$result=mysqli_fetch_array($query);


        //$Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $Caracteres = '0123456789';
        $ca = strlen($Caracteres);
        $ca--;
        $Hash = '';
        for ($x = 1; $x <= 6; $x++) {
            $Posicao = rand(0, $ca);
            $Hash .= substr($Caracteres, $Posicao, 1);
        }
        
        class PDF extends FPDF {
            // Cabecera de p�gina
            function Header()
            {
                // Logo
                $this->Image('img/credencial_vehiculo.png',0,0,279,217);
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
        $pdf = new PDF('L','mm',array(279,216));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
      
        
        #$pdf->Image($result['url_foto'] ,200,6,65,68);        
        #if (!empty($result['logo'])) {
        #    $pdf->Image($result['logo'],10,7,17,15);
        #} 

        $pdf->Image($result['url_foto'] ,200,6,65,68);
        if (!empty($logo)) {
            $pdf->Image($logo,10,7,17,15);
        } 
       
        
        $pdf->SetTextColor(14,14,14);
        $pdf->SetFont('Arial','B',20);
        $pdf->SetXY(60,29);
        $pdf->Cell(45,8,utf8_decode($result['nom_contratista']),0);
        $pdf->SetXY(52,48);
        $pdf->Cell(45,8,utf8_decode($result['nombre_contrato']),0);
        $pdf->SetXY(52,62);
        $pdf->Cell(45,8,utf8_decode($result['nom_mandante']),0);
        $pdf->SetXY(52,75);
        $pdf->Cell(45,8,utf8_decode($result['tipo']),0);
        $pdf->SetXY(50,90);
        $pdf->Cell(45,8,utf8_decode($result['marcar']).' '.$result['modelo'],0);
        $pdf->SetXY(50,105);
        $pdf->Cell(45,8,utf8_decode($result['color']),0);
        $pdf->SetXY(52,120);
        $pdf->Cell(44.5,8,$result['patente'],0);
        #$pdf->SetXY(28,50.5);
        #$pdf->Cell(45,8,$result['validez'],0);

        $pdf->SetTextColor(22,33,78);
        $pdf->SetFont('Arial','B',70);
        $pdf->SetXY(90,167);
        $pdf->Cell(44.5,8,substr($result['codigo'],0,3),0);
        $pdf->SetXY(150,167);
        $pdf->Cell(44.5,8,substr($result['codigo'],-3),0);
        $pdf->SetTextColor(255,255,255);

        $carpeta='img/qr/vehiculos/'.$result['patente'].'/'.$result['rut'].'/';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        
        $link ='https://prueba.facilcontrol.cl/validar_qr_vehiculo.php?codigo='.$result['codigo'];
        
        $qr=$carpeta.'/qr_'.$result['contrato'].'_'.$result['patente'].'.png';
        QRcode::png($link,$qr,QR_ECLEVEL_L,10,2);
        $pdf->Image($qr,200,77,65,50);
        
        $pdf->Output('credencial_vehiculo_'.$result['contrato'].'_'.$result['patente'].'.pdf','I');

?>