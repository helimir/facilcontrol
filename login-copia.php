<?php
/**
 * @author lolkittens
 * @copyright 2022
 */

session_start();
error_reporting(0);
include('config/config.php');


    	
        
        $usuario=mysqli_real_escape_string($con,(strip_tags($_POST["rut"],ENT_QUOTES)));
        $password=mysqli_real_escape_string($con,(strip_tags($_POST["pass"],ENT_QUOTES)));  
        
        //$query_pass = mysqli_query($con,"SELECT pass FROM users WHERE pass =\"$password\" ");
        //$result_pass=mysqli_fetch_array($query_pass);  
        //$pass=$result_pass['pass'];
        
        $query_usuario = mysqli_query($con,"SELECT * FROM users WHERE usuario =\"$usuario\" ");
        $result_usuario=mysqli_fetch_array($query_usuario);
        $hash=$result_usuario['pass'];
        $pass=password_verify($password,$hash );
        
        $nivel=$result_usuario['nivel'];
        
        if ($result_usuario['pass']!=NULL) {
            if ($query_usuario and $pass) {            
            
                $query = mysqli_query($con,"SELECT * FROM users WHERE usuario =\"$usuario\" ");
                $result=mysqli_fetch_array($query);
                
                if ($result['estado']!=0) {                    
                    $_SESSION['usuario']=$usuario;
                    $_SESSION['nivel']=$result_usuario['nivel'];
                    
                    // administrador
                    if ($_SESSION['nivel']==1) {
                      echo '<script>window.location.href="https://facilcontrol.cl/list_mandantes.php"</script>';
                      
                    }
                    
                    if ($_SESSION['nivel']==2) {
                      $query_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='$usuario' "); 
                      $result_mandante=mysqli_fetch_array($query_mandante);  
                      $_SESSION['mandante']=$result_mandante['id_mandante'];
                      echo '<script>window.location.href="https://facilcontrol.cl/list_contratos.php"</script>';
                    }
                    
                    if ($_SESSION['nivel']==3) {
                      $query_contratista=mysqli_query($con,"select * from contratistas where rut='$usuario' "); 
                      $result_contratista=mysqli_fetch_array($query_contratista);
                      $_SESSION['contratista']=$result_contratista['id_contratista'];
                      $_SESSION['mandante']=$result_contratista['mandante'];  
                      echo '<script>window.location.href="https://facilcontrol.cl/list_contratos_contratistas.php"</script>';
                      $_SESSION['url']='list_contratos_contratistas.php';
                      $_SESSION['titulo']='Listado Contratos';
                    }
                } else {
                    echo '<script>alert("Cuenta No Validada");window.location.href="admin.php"</script>';
                 }   
                  
    
            } else {
                echo '<script>alert("Usuario y/o Password Invalida");window.location.href="admin.php"</script>';
            }
            
        } else {
           echo '<script>alert("Usuario No Validado");window.location.href="admin.php"</script>';
        }           


?>