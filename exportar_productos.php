<?php
include('config/config.php');

ini_set('date.timezone','America/Santiago'); 
$hora=date("H-i-s");

 function make_date(){
        return strftime("%d-%m-%Y", time());
 }
 $fecha =make_date();

$Name = 'lista_productos_'.$fecha.'_'.$hora.'.csv';
$FileName = "./$Name";
$Datos = 'No;Linea;Producto;Cantidad;Costo_Neto_Unitario;Costo_Neto_Total;Margen;Precio_Unitario_Venta;Precio_Venta_Total';
$Datos .= "\r\n";

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.basename($Name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($Name));

        
 
echo $Datos;

 


?>