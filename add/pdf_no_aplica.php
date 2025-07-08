<?php
include('config/config.php');
include('fpdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        
        $this->SetTextColor(255,255,255);
        $this->Image('assets/img/logo_fc.png',0,0,220,60);
        $this->SetFont('Arial','B',14);
        $this->SetXY(10,5);
        $this->Cell(0,6,'Documento No Aplica',0,1,'C',false);     
    
        $this->Ln(10);
    }

    function mensaje() {
        $this->Cell(0,6,'Asesora: ',0,0,'L',false);
    }
}
    

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->mensaje();
    $pdf->Output('I','no_aplica.pdf'); 

?>