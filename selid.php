<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    


    $query=mysqli_query($con,"select * from perfiles  where id_perfil='".$_GET['id']."' ");
    $fila=mysqli_fetch_array($query);
    
    $valor=unserialize($fila['doc']);
    
    echo '<div class="modal-body"> ';
    
     //echo '<div class="row">';
       //echo '<h3 class=""><strong>Perfil: </strong> '.$fila['nombre_perfil'].' </h3> ';
      //echo '</div>';    
    
    echo '<div class="row">';
        echo '<table class="table ">';
            
                echo '<tbody>';
                 $i=1;
                 foreach ($valor as $row) {
                       
                      if ($_GET['tipo']==0) {
                          $query2=mysqli_query($con,"select * from doc where id_doc=$row and estado=1");
                          $fila2=mysqli_fetch_array($query2);
                      } else {
                          $query2=mysqli_query($con,"select * from doc_autos where id_vdoc=$row and estado=0");
                          $fila2=mysqli_fetch_array($query2);
                      }

                       if ($fila2) {
                           echo '<tr>';
                              echo '<td style="width: 1%">'.$i.'.</td><td style="width: 50%">'.$fila2['documento'].'</td>';
                           echo '</tr>';
                       };    
                    $i++; 
                  };   
                 
                echo '</tbody>';
                echo '</table>';
            echo '</div>';
   
   echo '</div>'; 
   
   echo '<div class="modal-footer">';        
            //echo '<a style="color: #fff;" class="btn btn-success" href="" >IMPRIMIR</a>';     
            echo '<a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>';
   echo '</div>';
   


?>