<?php


session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$query=mysqli_query($con,"select m.razon_social,  c.* from contratos as c Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratistas as o On o.id_contratista=c.contratista  where  c.estado=1 and o.email='".$_SESSION['usuario']."' and c.contratista=o.id_contratista ");
$result=mysqli_fetch_array($query);

$query2=mysqli_query($con,"select * from trabajadores_asignados where id_trabajador='".$_GET['id']."' ");
$result2=mysqli_fetch_array($query2);
$contratos=unserialize($result2['contratos']);

// a:2:{i:0;s:2:"28";i:1;s:2:"29";} 
// a:1:{i:0;s:2:"29";}
// a:1:{i:0;s:2:"28";}
 
?>    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">

   <form  method="post" id="frmAsignar"> 
    <div class="modal-body">
    
      <div class="row">
            <table class="table ">
            
               <thead>
                <tr>
                    <th>Contrato<?php ?></th>
                    <th>Mandante</th>
                    <th>Asignar/Quitar</th>
                </tr>
                </thead>
                
               <tbody>
                
                <?php
                     $i=0;        
                     $condicion=false;              
                     foreach ($query as $row) { 
                        
                        foreach ($contratos as $row2) {
                                
                                if ($row2==$row['id_contrato']) {
                                    $condicion=true;
                                    break;
                                } else {
                                    $condicion=false;
                                }
                        }
                        ?>
                               <tr>
                                  <td style=""><?php echo $row['nombre_contrato'] ?></td>
                                  <td style=""><?php echo $row['razon_social'] ?></td>
                                  
                                  <?php if ($condicion==true) { ?>
                                    <td><div class="i-checks"><input type="checkbox" name="contratos[]" value="<?php echo $row['id_contrato'] ?>" checked="" />  </div></td>
                                  <?php } else { ?>                                    
                                     <td><div class="i-checks"><input type="checkbox" name="contratos[]" value="<?php echo $row['id_contrato'] ?>" />  </div></td>
                                  <?php } ?>
                                    
                              </tr>
                         
                 <?php } ?>
                  <input type="hidden" name="trabajador" id="trabajador" value="<?php echo $_GET['id'] ?>" />     
                
              </tbody>
           </table>
      </div>
   </div>
   <div class="modal-footer">
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
            <a style="color: #fff;" class="btn btn-success" href="" onclick="asignar_contrato()" >Asignar Contrato</a>
  </div>
  </form> 

<!-- Mainly scripts -->
    
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>
    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>


<!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
<!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
         
          
       function asignar_contrato() {
          var valores=$('#frmAsignar').serialize();
            $.ajax({
    			method: "POST",
                url: "add/asignar_contrato.php",
                data: valores,
    			success: function(data){			  
                 if (data==1) {
                    window.location.href='list_trabajadores.php?sms=1';
    			  } 
                  if (data==2) {
                     window.location.href='list_trabajadores.php?sms=2';
    			  }
                  if (data==3) {
                    window.location.href='list_trabajadores.php?sms=3';
    			  }
                  
                  if (data==0) {                  
                   window.location.href='list_trabajadores.php?sms=0';                                                  
    			  }
    			}                
           });
         }


</script>
        
        