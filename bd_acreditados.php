<?php
require ('config/config.php');

ini_set('date.timezone','America/Santiago'); 
$hora=date("H-i-s");

 function make_date(){
        return strftime("%d-%m-%Y", time());
 }
 $fecha =make_date();

$Name = 'DB_acreditados_'.$fecha.'_'.$hora.'.csv';
$FileName = "./$Name";
$Datos = 'Mandante;RUT;Contratista;RUT;Nombre;RUT;Contrato;Cargo;Perfil;Codigo;Documento;Tipo_documento;Fecha_Cargado;Estado';
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
;
foreach ($query as $oRow) {

    switch ($oRow['estado_t']) {
      case  '0':$estado_t='ACTIVO';break;
      case  '1':$estado_t='ACTIVO';break;
      case  '2':$estado_t='DESVINCULADO';break;
    }

    $dia=substr($oRow['fecha'],8,2);
    $mes=substr($oRow['fecha'],5,2);
    $ano=substr($oRow['fecha'],0,4);
    $fecha=$dia.'-'.$mes.'-'.$ano;
    $documentos=unserialize($oRow['documentos']);

    #obtener documentos mensuales verificados
    $query_dm=mysqli_query($con,"select d.documento, t.* from mensuales_trabajador as t Left join doc_mensuales as d On d.id_dm=t.doc where t.trabajador='".$oRow['trabajador']."' and t.contratista='".$oRow['contratista']."' and t.contrato='".$oRow['contrato']."' and t.verificado='1' ");
    $hay_dm=mysqli_num_rows($query_dm);

    #obtener documentos desvinculates verificados
    $query_des=mysqli_query($con,"select  d.* from desvinculaciones as d  where d.trabajador='".$oRow['trabajador']."' and d.contratista='".$oRow['contratista']."' and d.contrato='".$oRow['contrato']."' and d.verificado='1' ");
    $hay_des=mysqli_num_rows($query_des);

    #obtener documentos extraordinarios verificados
    $query_ex=mysqli_query($con,"select * from documentos_extras where trabajador='".$oRow['trabajador']."' and  contratista='".$oRow['contratista']."' and contrato='".$oRow['contrato']."' and estado='3' ");
    $hay_ex=mysqli_num_rows($query_ex);

    $realizado=0;
    $realizado_des=0;
    $realizado_ex=0;

    foreach ($documentos as $row) {
        $query_d=mysqli_query($con,"select * from doc where id_doc='".$row."' ");
        $result_d=mysqli_fetch_array($query_d);
        $trabajador=$oRow['nombre1'].' '.$oRow['apellido1'];
        
          $tipo_doc="acreditacion"; 
          $Datos .= $oRow['nom_mandante'].";".$oRow['rut_m'].";".$oRow['nom_contratista'].";".$oRow['rut_c'].";".$trabajador.";".$oRow['rut_t'].";".$oRow['nombre_contrato'].";".$oRow['nom_cargo'].";".utf8_decode($oRow['nombre_perfil']).";".$oRow['codigo'].";".$result_d['documento'].";Acreditacion;".$fecha.";".$estado_t;
          $Datos .= "\r\n"; 
        
          #documentos mensuales
        if ($hay_dm>0 and $realizado==0) {  
          $realizado=3;
          foreach ($query_dm as $row_men) {

            $dia_men=substr($row_men['creado'],8,2);
            $mes_men=substr($row_men['creado'],5,2);
            $ano_men=substr($row_men['creado'],0,4);
            $fecha_men=$dia_men.'-'.$mes_men.'-'.$ano_men;

            $Datos .= $oRow['nom_mandante'].";".$oRow['rut_m'].";".$oRow['nom_contratista'].";".$oRow['rut_c'].";".$trabajador.";".$oRow['rut_t'].";".$oRow['nombre_contrato'].";".$oRow['nom_cargo'].";".utf8_decode($oRow['nombre_perfil']).";".$oRow['codigo'].";".$row_men['documento'].";Mensual;".$fecha_men.";".$estado_t;
            $Datos .= "\r\n"; 
          }
        } 
        
        # documentos desvinculaciones
        if ($hay_des>0 and $realizado_des==0) {  
          $realizado_des=1;
          foreach ($query_des as $row_des) {
            
            if ($row_des['tipo']==1) {
              $documento='documento_desvinculante_contratista_'.$oRow['rut_t'].'.pdf';
            } else {
              $documento='documento_desvinculante_contrato_'.$oRow['rut_t'].'.pdf';
            }  

            $dia_des=substr($row_des['fecha_desvinculado'],8,2);
            $mes_des=substr($row_des['fecha_desvinculado'],5,2);
            $ano_des=substr($row_des['fecha_desvinculado'],0,4);
            $fecha_des=$dia_des.'-'.$mes_des.'-'.$ano_des;
 
            $Datos .= $oRow['nom_mandante'].";".$oRow['rut_m'].";".$oRow['nom_contratista'].";".$oRow['rut_c'].";".$trabajador.";".$oRow['rut_t'].";".$oRow['nombre_contrato'].";".$oRow['nom_cargo'].";".utf8_decode($oRow['nombre_perfil']).";".$oRow['codigo'].";".$documento.";Desvinculacion;".$fecha_des.";".$estado_t;
            $Datos .= "\r\n"; 
          }
        }

        # documentos extras
        if ($hay_ex>0 and $realizado_ex==0) {  
          $realizado_ex=1;
          foreach ($query_ex as $row_ex) {
          
            $dia_ex=substr($row_ex['creado'],8,2);
            $mes_ex=substr($row_ex['creado'],5,2);
            $ano_ex=substr($row_ex['creado'],0,4);
            $fecha_ex=$dia_ex.'-'.$mes_ex.'-'.$ano_ex;

            $Datos .= $oRow['nom_mandante'].";".$oRow['rut_m'].";".$oRow['nom_contratista'].";".$oRow['rut_c'].";".$trabajador.";".$oRow['rut_t'].";".$oRow['nombre_contrato'].";".$oRow['nom_cargo'].";".utf8_decode($oRow['nombre_perfil']).";".$oRow['codigo'].";".$row_ex['documento'].";Extraordinario;".$fecha_ex.";".$estado_t;
            $Datos .= "\r\n"; 
          }
        }



        $i=$i+1;        
    }    
}   
 
echo $Datos;

 


?>