<?php

require ('config/config.php');

ini_set('date.timezone','America/Santiago'); 
$hora=date("H-i-s");

 function make_date(){
        return strftime("%d-%m-%Y", time());
 }
 $fecha =make_date();

$Name = 'DB_acreditados_trabajadores_'.$fecha.'_'.$hora.'.csv';
$FileName = "./$Name";
$Datos = 'Mandante;RUT;Contratista;RUT;Nombre;RUT;Contrato;Cargo;Perfil;Codigo;Validez;Fecha_Acreditado;Estado;Fecha_Desvinculado';
$Datos .= "\r\n";

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.basename($Name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($Name));
        

$query=mysqli_query($con,"select c.rut as rut_c,m.rut_empresa as rut_m, a.creado as fecha, p.nombre_perfil, o.nombre_contrato, r.cargo as nom_cargo, c.razon_social as nom_contratista,m.razon_social as nom_mandante, t.nombre1, t.apellido1, t.rut as rut_t, c.razon_social, a.*, a.estado as estado_t from trabajadores_acreditados as a Left Join trabajador as t On t.idtrabajador=a.trabajador Left Join contratistas as c On c.id_contratista=a.contratista Left Join mandantes as m On m.id_mandante=a.mandante Left Join cargos as r On r.idcargo=a.cargo Left Join perfiles as p On p.id_perfil=a.perfil Left Join contratos as o On o.id_contrato=a.contrato order by  c.razon_social asc ");

$i=1;

foreach ($query as $oRow) {

    switch ($oRow['estado_t']) {
      case  '0':$estado_t='ACTIVO';break;
      case  '1':$estado_t='ACTIVO';break;
      case  '2':$estado_t='DESVINCULADO';break;
    }

    if ($oRow['estado_t']==2) {
        $query_d=mysqli_query($con,"select * from desvinculaciones where trabajador='".$oRow['idtrabajador']."'  ");
        $result_d=mysqli_fetch_array($query_d);
    } else {
        $result_d['fecha_desvinculado']="";
    }

    $dia=substr($oRow['fecha'],8,2);
    $mes=substr($oRow['fecha'],5,2);
    $ano=substr($oRow['fecha'],0,4);
    $fecha=$dia.'-'.$mes.'-'.$ano;
    $documentos=unserialize($oRow['documentos']);
   
        $query_des=mysqli_query($con,"select * from desvinculaciones where trabajador='".$oRow['idtrabajador']."' ");
        $result_des=mysqli_fetch_array($query_d);

        $trabajador=$oRow['nombre1'].' '.$oRow['apellido1'];
        $Datos .=  $oRow['nom_mandante'].";".$oRow['rut_m'].";".$oRow['nom_contratista'].";".$oRow['rut_c'].";".$trabajador.";".$oRow['rut_t'].";".$oRow['nombre_contrato'].";".$oRow['nom_cargo'].";".utf8_decode($oRow['nombre_perfil']).";".$oRow['codigo'].";".$oRow['validez'].";".$fecha.";".$estado_t.";".$result_d['fecha_desvinculado'];
        $Datos .= "\r\n"; 
        $i=$i+1;  
}   
 
echo $Datos;

 


?>