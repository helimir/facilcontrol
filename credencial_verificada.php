<?php
session_start();
require('fpdf/fpdf.php');

define("DB_HOST", "localhost");//DB_HOST:  generalmente suele ser "127.0.0.1"
define("DB_USER", "clubicl");//Usuario de tu base de datos
define("DB_PASS", "Arielg12345678!!");//Contraseña del usuario de la base de datos
define("DB_NAME", "clubicl_proyecto");//Nombre de la base de datos
$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$con){
        @die("<h2 style='text-align:center'>Imposible conectarse a la base de datos en este instante! </h2>".mysqli_error($con));
}
if (@mysqli_connect_errno()) {
       @die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error()); 
}

//$query=mysqli_query($con,"select t.* from trabajador as t where t.idtrabajador='".$_GET['id']."' ");
//$result=mysqli_fetch_array($query);

$query=mysqli_query($con,"select t.*, o.*, n.razon_social as contratista, n.id_contratista, m.razon_social as mandante, c.nombre_contrato from observaciones as o Left join contratos as c On c.id_contrato=o.contrato Left Join contratistas as n On n.id_contratista=c.contratista Left Join mandantes as m On m.id_mandante=o.mandante Left Join trabajador as t On t.idtrabajador=o.trabajador where o.trabajador='".$_GET['id']."' and o.contrato='".$_SESSION['contrato']."' ");
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
            // Cabecera de página
            function Header()
            {
                // Logo
                $this->Image('img/crede1.jpg',7,5,100);
                $this->Image('img/crede2.jpg',110,5,100);
                // Arial bold 15
                //$this->SetFont('Arial','B',15);
                // Movernos a la derecha
                //$this->Cell(80);
                // Título
                //$this->Cell(30,10,'Title',1,0,'C');
                // Salto de línea
                $this->Ln(6);
            }
            
            // Pie de página
            function Footer()
            {
                // Posición: a 1,5 cm del final
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',6);
                // Número de página
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }
        }
        
        
        
        // Creación del objeto de la clase heredada
        $pdf = new PDF('L','mm',array(216,100));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        //$pdf->SetFont('Arial','',10);
        //$pdf->Cell(100,5,'Informacion del Pedido',0,0,'L');
        //$pdf->Ln(8);
        //$pdf->SetXY(40,5);
        //$pdf->SetFont('Courier','B',18);
        //$pdf->Cell(7,9,'www.facilcontrol.cl',0); #16214E
        
        $url='img/trabajadores/'.$result['id_contratista'].'/'.$result['rut'].'/foto_'.$result['rut'].'.png';
        if (file_exists($url)) {
            $pdf->Image($url,11,9,26,26);
        }    
        
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial','B',7);
        $pdf->SetXY(40,11.5);
        $pdf->Cell(45,8,utf8_decode($result['contratista']),0);
        $pdf->SetXY(40,20);
        $pdf->Cell(45,8,utf8_decode($result['nombre_contrato']),0);
        $pdf->SetXY(40,28.5);
        $pdf->Cell(45,8,utf8_decode($result['mandante']),0);
        $pdf->SetXY(24,36);
        $pdf->Cell(45,8,utf8_decode($result['nombre1']).' '.utf8_decode($result['apellido1']),0);
        $pdf->SetXY(18,42.2);
        $pdf->Cell(44.5,8,$result['rut'],0);
        $pdf->SetXY(28,48.5);
        if ($result['fecha']=="0000-00-00") {
            $pdf->Cell(45,8,'Indefinido',0);
        } else {
            $pdf->Cell(45,8,$result['fecha'],0);
        }
        $pdf->SetTextColor(22,33,78);
        $pdf->SetFont('Arial','B',40);
        $pdf->SetXY(130,28);
        $pdf->Cell(44.5,8,substr($result['codigo_verificacion'],0,3),0);
        $pdf->SetXY(163,28);
        $pdf->Cell(44.5,8,substr($result['codigo_verificacion'],-3),0);
        $pdf->SetTextColor(255,255,255);
        //$pdf->SetXY(6,21);
        //$pdf->Cell(45,21,'Validez: '.$result_fecha['fecha'],0);
        //$pdf->SetXY(6,24.5);
        //$pdf->Cell(45,24.5,'Contratista: '.utf8_decode($result_fecha['contratista']),0);
        //$pdf->SetXY(6,28);
        //$pdf->Cell(45,28,'Mandante: '.utf8_decode($result_fecha['mandante']),0);
        
        
        //$pdf->SetFont('Arial','B',10);
        //$pdf->SetXY(6,35);
        //$pdf->Cell(45,35,'Codigo Verificacion:'.$Hash,0);
            
        
        
        
        $pdf->Output('etiqueta.pdf','I');

?>