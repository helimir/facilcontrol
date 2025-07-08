<?php
include('../config/config.php');
session_start();
function make_date(){
        return strftime("%d-%m-%Y", time());
 }
 $fecha =make_date();

$idtrabajador=$_POST['idtrabajador'];
$rut=$_POST['rut'];
$nombre1=trim(utf8_decode($_POST['nombre1']));
$nombre2=trim(utf8_decode($_POST['nombre2']));
$apellido1=trim(utf8_decode($_POST['apellido1']));
$apellido2=trim(utf8_decode($_POST['apellido2']));
$direccion1=trim(utf8_decode($_POST['direccion1']));
$direccion2=$_POST['direccion2'];
$region=utf8_decode($_POST['region']);
$comuna=utf8_decode($_POST['comuna']);
$estadocivil=$_POST['estadocivil'];
$email=trim($_POST['email']);
$telefono=$_POST['telefono'];
$fnacimiento=$_POST['dia']."-".$_POST['mes']."-".$_POST['ano'];

$tpantalon=$_POST['tpantalon'];
$tpolera=$_POST['tpolera'];
$tzapatos=$_POST['tzapatos'];

$cargo=utf8_decode($_POST['cargo']);
$tipocargo=utf8_decode($_POST['tipocargo']);
$licencia=utf8_decode($_POST['licencia']);
$tipolicencia=utf8_decode($_POST['tipolicencia']);

$dia=utf8_decode($_POST['dia']);
$mes=utf8_decode($_POST['mes']);
$ano=utf8_decode($_POST['ano']);

$banco=utf8_decode($_POST['banco']);
$cuenta=trim(utf8_decode($_POST['cuenta']));
$tipocuenta=utf8_decode($_POST['tipocuenta']);
$afp=utf8_decode($_POST['afp']);
$salud=utf8_decode($_POST['salud']); 

$contratista=$_POST['idcontratista'];
 
#if ( $rut!='' and $nombre1!='' and $apellido1!='' and $direccion1!='' and $direccion2!='' and $email!='' and $telefono!='' and $estadocivil!='0'  ) {
    
    $queryrut=mysqli_query($con,"select rut from trabajador where rut='$rut' and contratista='$contratista' "); 
    $resultrut=mysqli_num_rows($queryrut);
    
     if ($resultrut==0) {    
        if ($_POST['accion']=='guardar') {
            $sqladd="insert into trabajador (nombre1,nombre2,apellido1,apellido2,rut,direccion1,direccion2,region,comuna,telefono,email,fnacimiento,estadocivil,dia,mes,ano,licencia,tipolicencia,tpantalon,tpolera,tzapatos,banco,cuenta,tipocuenta,afp,salud,contratista) values ('".utf8_encode($nombre1)."','".utf8_encode($nombre2)."','".utf8_encode($apellido1)."','".utf8_encode($apellido2)."','".$rut."','".utf8_encode($direccion1)."','".utf8_encode($direccion2)."','".utf8_encode($region)."','".utf8_encode($comuna)."','".$telefono."','".$email."','".$fnacimiento."','".$estadocivil."','".$dia."','".$mes."','".$ano."','".$licencia."','".$tipolicencia."','".$tpantalon."','".$tpolera."','".$tzapatos."','".$banco."','".$cuenta."','".$tipocuenta."','".$afp."','".$salud."','".$contratista."') ";
            $add= mysqli_query($con,$sqladd);
            mysqli_query($con,"delete from notificaciones where item='Crear Trabajadores' and contratista='$contratista' ");
            
            $carpeta = '../doc/trabajadores/'.$contratista.'/'.$rut.'/';
            mkdir($carpeta, 0777, true);
            
           
            if ($add) {    		
               # trabajador creado
               echo 0;
            } else {
               # trabajador no creado 
               echo 1;
            }          
        }
            
        if ($_POST['accion']=='editar') {            
            $sqla="update trabajador set  nombre1='".utf8_encode($nombre1)."',nombre2='".utf8_encode($nombre2)."',apellido1='".utf8_encode($apellido1)."',apellido2='".utf8_encode($apellido2)."',direccion1='".utf8_encode($direccion1)."',direccion2='".utf8_encode($direccion2)."',region='".utf8_encode($region)."',comuna='".utf8_encode($comuna)."',telefono='".$telefono."', email='".$email."',fnacimiento='".$fnacimiento."',estadocivil='".$estadocivil."', fecha='".$fecha."',dia='".$dia."',mes='".$mes."',ano='".$ano."', licencia='".$licencia."',tipolicencia='".$tipolicencia."', banco='".$banco."', cuenta='".utf8_encode($cuenta)."',tipocuenta='".utf8_encode($tipocuenta)."',afp='".$afp."', salud='".$salud."', tpantalon='".$tpantalon."', tpolera='".$tpolera."', tzapatos='".$tzapatos."'   where idtrabajador='".$idtrabajador."'  ";
            $add= mysqli_query($con,$sqla);
            if ($add) {  
               # actualizado
               echo 3; 
            } else {
               # no se pudo actualizar 
               echo 4;
            }
        }
    } else {
        echo 2; 
    } 
#} else {
    #echo $email;
#}         

    
?>