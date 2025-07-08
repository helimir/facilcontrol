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
$documento=isset($_POST['documento']) ? $_POST['documento']: ''; 
$mensaje_na=isset($_POST['mensaje']) ? $_POST['mensaje']: '';
$tipo=isset($_POST['tipo']) ? $_POST['tipo']: '';

if ($tipo==1) {

        $query_guardar=mysqli_query($con,"insert into noaplica (contratista,mandante,documento,extra,mensaje) values ('$contratista','$mandante','$doc','$documento','$mensaje') ");

        if ($query_guardar) {

            $query_contratista=mysqli_query($con,"select c.razon_social as contratista, m.razon_social as mandante, c.rut, m.rut_empresa from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where c.id_contratista='$contratista' ");
            $result_contratista=mysqli_fetch_array($query_contratista);

            $query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$doc'  ");
            $result_doc=mysqli_fetch_array($query_doc);

            
            $nom_contratista=$result_contratista['contratista'];
            $nom_mandante=$result_contratista['mandante'];
            $rut_contratista=$result_contratista['rut'];
            $rut_mandante=$result_contratista['rut_empresa'];

            // notificacion que falta perfiles. accion. control: nombre del documento
            $item='Documento No Aplica';                 
            $nivel=3;
            $tipo=1;
            $envia=$contratista;
            $recibe=$mandante; 
            $mensaje="El contratista <b>$nom_contratista</b> indica que el <b>$documento</b> no aplica.";
            $mensaje2="El contratista $nom_contratista indica que el $doc no aplica.";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de contratista";
            $url="gestion_doc_extradordinarios_mandante.php"; 
        
            $query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and extra='$documento' ");
            $result_na=mysqli_fetch_array($query_na);
            $no_aplica=$result_na['id_na'];
            

            
            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and documento='$documento' and item='Documento Extraordinario Solicitado' ");
            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and documento='$documento' and item='Documento Extraordinario Recibido' ");            
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,id_noaplica) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$documento','$documento','$no_aplica') ");
            mysqli_query($con,"delete from doc_comentarios_extra where documento='$documento' and contratista='$contratista' and mandante='$mandante' ");
            mysqli_query($con,"update documentos_extras set estado='1' where documento='$documento' and contratista='$contratista' and mandante='$mandante' ");
                        
            $nombre=$documento.'_'.$result_contratista['rut'].'.pdf';
            $url='doc/temporal/'.$mandante.'/'.$contratista.'/'.$nombre;        
            $query_a=mysqli_query($con,"insert into doc_subidos_contratista (documento,id_documento,contratista,mandante,url,noaplica) values ('$documento','$doc','$contratista','$mandante','$url','1') ");
        
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

}

if ($tipo==2) {
        $trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
        $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';

        $query_guardar=mysqli_query($con,"insert into noaplica (contratista,mandante,documento,extra,mensaje,trabajador,contrato) values ('$contratista','$mandante','$doc','$documento','$mensaje','$trabajador','$contrato') ");

        if ($query_guardar) {

            $query_contratista=mysqli_query($con,"select c.razon_social as contratista, m.razon_social as mandante, c.rut, m.rut_empresa from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where c.id_contratista='$contratista' ");
            $result_contratista=mysqli_fetch_array($query_contratista);

            $query_trab=mysqli_query($con,"select c.nombre_contrato, a.codigo, t.rut, t.nombre1, t.apellido1 from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador Left join contratos as c On c.id_contrato=a.contrato where a.trabajador='$trabajador' and a.contrato='$contrato' and a.estado!='2' ");
            $result_trab=mysqli_fetch_array($query_trab);
            $nom_trabajador=$result_trab['nombre1']." ".$result_trab['apellido1'];
            $nombre_contrato=$result_trab['nombre_contrato'];
            $nom_trabajador2=$result_trab['nombre1']." ".$result_trab['apellido1'].' '.$result_trab['rut'];
            
            $nom_contratista=$result_contratista['contratista'];
            $nom_mandante=$result_contratista['mandante'];
            $rut_contratista=$result_contratista['rut'];
            $rut_mandante=$result_contratista['rut_empresa'];

            // notificacion que falta perfiles. accion. control: nombre del documento
            $item='Documento No Aplica';                 
            $nivel=3;
            $tipo=1;
            $envia=$contratista;
            $recibe=$mandante;           
            $mensaje="El contratista <b>$nom_contratista</b> envio el documento extraordinario <b>$documento</b> contrato <b>$nombre_contrato</b> trabajador <b>$nom_trabajador</b> No aplica.";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de contratista";
            $url="gestion_doc_extradordinarios_mandante_contrato.php"; 
        
            $query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and extra='$documento' and contrato='$contrato' and trabajador='$trabajador' ");
            $result_na=mysqli_fetch_array($query_na);
            $no_aplica=$result_na['id_na'];
            
            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and documento='$documento' and item='Documento Extraordinario Solicitado' and trabajador='$trabajador' and contrato='$contrato' ");
            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and documento='$documento' and item='DDocumento Extraordinario Recibido'  and trabajador='$trabajador' and contrato='$contrato' ");
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,id_noaplica,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$documento','$documento','$no_aplica','$trabajador','$contrato') ");
            mysqli_query($con,"delete from doc_comentarios_extra where documento='$documento' and contratista='$contratista' and mandante='$mandante' and trabajador='$trabajador' and contrato='$contrato' ");
            mysqli_query($con,"update documentos_extras set estado='1' where documento='$documento' and contratista='$contratista' and mandante='$mandante' and trabajador='$trabajador' and contrato='$contrato' ");
                        
            $nombre=$documento.'_'.$result_trab['rut'].'.pdf';
            $url='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/'. $nombre;
        
            mysqli_query($con,"insert into doc_subidos_contratista (documento,id_documento,contratista,mandante,url,noaplica,trabajador,contrato) values ('$documento','$doc','$contratista','$mandante','$url','1','$trabajador','$contrato') ");
                    
            $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            class PDF extends FPDF {

                function Header() {
                    $this->Image('../assets/img/logo_fc.png',10,10,40,20);
                    $this->SetFont('Arial','B',14);
                    $this->SetXY(55,20);
                    $this->Cell(0,6,'Documento No aplica Extra Trabajadores de un Contrato',0,0,'L',false);     
                
                    $this->Ln(15);
                }
            
                function mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento,$nombre_contrato,$nom_trabajador2) {
                                    
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
                    $this->MultiCell(0,4,'Contrato: ',0,'L',false);
                    $this->SetXY(35,45);
                    $this->SetFont('Arial','',10);     
                    $this->MultiCell(0,4,utf8_decode($nombre_contrato),0,'L',false);

                    $this->SetXY(10,50);
                    $this->SetFont('Arial','B',10);        
                    $this->MultiCell(0,4,'Trabajador: ',0,'L',false);
                    $this->SetXY(35,50);
                    $this->SetFont('Arial','',10);     
                    $this->MultiCell(0,4,utf8_decode($nom_trabajador2),0,'L',false);
                  
                    $this->SetXY(10,60);
                    $this->SetFont('Arial','B',10);
                    $this->MultiCell(0,4,'Documento: ',0,'L',false);
                    $this->SetXY(10,65);
                    $this->SetFont('Arial','',10);
                    $this->MultiCell(0,4,utf8_decode($documento),0,'L',false);
                    
                    $this->SetXY(10,75);
                    $this->SetFont('Arial','B',10);
                    $this->MultiCell(0,4,'Mensaje: ',0,'L',false);
                    $this->SetXY(10,80);
                    $this->SetFont('Arial','',10);
                    $this->MultiCell(0,4,utf8_decode($mensaje_na),0,'J',false);
            
                }
            }
                
            
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->mensaje($mensaje_na,$nom_contratista,$nom_mandante,$documento,$nombre_contrato,$nom_trabajador2);
            #$pdf->Output('I','no_aplica.pdf'); 
            $pdf->Output('F',$carpeta.$documento.'_'.$result_trab['rut'].'.pdf');
                
            echo 0 ;



        } else {
            echo 1;
        }

}
    
    
    

?>