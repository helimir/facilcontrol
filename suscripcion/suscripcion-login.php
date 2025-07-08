<?php
session_start();
include('config/config.php');
date_default_timezone_set('America/Santiago');
$fecha = date('Y-m-d H:m:s', time());

$cliente=$_POST['cliente'];
$password=$_POST['pass'];

$query_email=mysqli_query($con,"select * from registro where email='$cliente' ");
$result_email=mysqli_fetch_array($query_email);        
$existe_email=mysqli_num_rows($query_email);

$hash=$result_email['pass'];
$pass=password_verify($password,$hash );
// si email existe
if ($existe_email>0) {
    
        $query_pass=mysqli_query($con,"select * from registro where raww='$password' ");
        $existe_pass=mysqli_num_rows($query_pass);

        // si pass coincide
        if ($existe_pass>0) {

            if ($result_email['confirmar']==1) {

                $estado=$result_email['estado'];

                //registrado sin plan
                if ($estado==0) {
                    $_SESSION['email']=$result_email['email'];
                    $_SESSION['nick']=$result_email['nick'];
                    $_SESSION['plan']=$result_email['plan'];
                    $_SESSION['monto']=$result_email['monto'];
                    echo 1;
                } 

                //registrado con plan
                if ($estado==1) {
                    $_SESSION['email']=$result_email['email'];
                    echo 2;
                }

                //registrado con plan vencido
                if ($estado==2) {
                    echo 4;
                }
            } else {
                echo 5;
            }
            // si pass no coindice
        } else {
            echo 3;
        }    

// sino existe email no esta registrado o ingreso con nick
} else {
    echo 0;
    
}



?>