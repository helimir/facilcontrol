<?php
include_once("config/config.php");
if(isset($_POST['import_data'])){    
    $contratista=$_POST['contratista'];
    
    
    // validate to check uploaded file is a valid csv file
    $file_mimes = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
   
    //if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$file_mimes)){
     if ($extension=='csv') {   
        if(is_uploaded_file($_FILES['file']['tmp_name'])){   
            $csv_file = fopen($_FILES['file']['tmp_name'], 'r');           
            //fgetcsv($csv_file);            
            // get data records from csv file
            while(($emp_record = fgetcsv($csv_file,0,";")) !== FALSE){
                if($emp_record[0]!='id') {
                    // Check if employee already exists with same email
                    $sql_query = "SELECT * FROM trabajador WHERE rut = '".$emp_record[5]."' and contratista='$contratista'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error1:". mysqli_error($con));
    				// if employee already exist then update details otherwise insert new record
                    if(mysqli_num_rows($resultset)) {                     
    					$sql_update = "update trabajador set  nombre1='".$emp_record[1]."',nombre2='".$emp_record[2]."',apellido1='".$emp_record[3]."',apellido2='".$emp_record[4]."', direccion1='".$emp_record[6]."',direccion2='".$emp_record[7]."',region='".$emp_record[8]."',comuna='".$emp_record[9]."',telefono='".$emp_record[10]."', dia='".$emp_record[11]."',mes='".$emp_record[12]."',ano='".$emp_record[13]."', email='".$emp_record[14]."',estadocivil='".$emp_record[15]."',tpantalon='".$emp_record[16]."', tpolera='".$emp_record[17]."', tzapatos='".$emp_record[18]."', licencia='".$emp_record[19]."',tipolicencia='".$emp_record[20]."', banco='".$emp_record[21]."',tipocuenta='".$emp_record[22]."', cuenta='".$emp_record[23]."',afp='".$emp_record[24]."', salud='".$emp_record[25]."' where rut='".$emp_record[5]."' ";
                        mysqli_query($con, $sql_update) or die("database error2:". mysqli_error($con));
                    } else{
                        
                        $mysql_insert="insert into trabajador (nombre1,nombre2,apellido1,apellido2,rut,direccion1,direccion2,region,comuna,telefono,dia,mes,ano,email,estadocivil,tpantalon,tpolera,tzapatos,licencia,tipolicencia,banco,tipocuenta,cuenta,afp,salud,contratista) values ('".utf8_encode($emp_record[1])."','".utf8_encode($emp_record[2])."','".utf8_encode($emp_record[3])."','".utf8_encode($emp_record[4])."','".$emp_record[5]."','".utf8_encode($emp_record[6])."','".$emp_record[7]."','".$emp_record[8]."','".$emp_record[9]."','".$emp_record[10]."','".$emp_record[11]."','".$emp_record[12]."','".$emp_record[13]."','".$emp_record[14]."','".$emp_record[15]."','".$emp_record[16]."','".$emp_record[17]."','".$emp_record[18]."','".$emp_record[19]."','".$emp_record[20]."','".utf8_encode($emp_record[21])."','".$emp_record[22]."','".$emp_record[23]."','".utf8_encode($emp_record[24])."','".utf8_encode($emp_record[25])."','".$contratista."') ";
    					mysqli_query($con, $mysql_insert) or die("database error3:". mysqli_error($con));
                        
                        $carpeta = 'doc/trabajadores/'.$contratista.'/'.$emp_record[5].'/';
                        mkdir($carpeta, 0777, true);
                    }
                }    
            }            
            fclose($csv_file);
            
            $query=mysqli_query($con,"update notificaciones set procesada=1 where item='Crear Trabajadores' and contratista='$contratista'  ");
            
            $import_status = '?import_status=success';
        } else {
            $import_status = '?import_status=error';
        }
    } else {
        $import_status = '?import_status=invalid_file';
    }
}
header("Location: list_trabajadores.php".$import_status);
?>