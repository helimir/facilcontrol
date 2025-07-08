<?php
include('config/config.php');
include('fpdf/fpdf.php');

class PDF extends FPDF {

    function Header() {
        $this->Image('assets/img/logo_fc.png',10,10,40,20);
        $this->SetFont('Arial','B',14);
        $this->SetXY(55,20);
        $this->Cell(0,6,'Documento No Aplica',0,0,'L',false);     
    
        $this->Ln(15);
    }

    function mensaje($mensaje,$contratista,$mandante,$documento) {
       
        $this->SetFont('Arial','B',10);        
        $this->MultiCell(0,4,'Contratista: ',0,'L',false);

        $this->SetXY(35,35);
        $this->SetFont('Arial','',10);     
        $this->MultiCell(0,4,utf8_decode($contratista),0,'L',false);

        $this->SetXY(10,40);
        $this->SetFont('Arial','B',10);        
        $this->MultiCell(0,4,'Mandante: ',0,'L',false);
        $this->SetXY(35,40);
        $this->SetFont('Arial','',10);     
        $this->MultiCell(0,4,utf8_decode($mandante),0,'L',false);
        
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
        $this->MultiCell(0,4,utf8_decode($mensaje),0,'J',false);

    }
}
    

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->mensaje();
    #$pdf->Output('I','no_aplica.pdf'); 
    $pdf->Output('F',$carpeta.'No_aplica_'.$documento.'.pdf');

?>