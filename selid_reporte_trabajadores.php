<?php
session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$contrato=$_GET['contrato'];

$query=mysqli_query($con,"select * from trabajadores_asignados  where contrato='$contrato' ");
$result=mysqli_fetch_array($query);
$trabajadores=unserialize($result['trabajadores']);
$cargos=unserialize($result['cargos']);

 
?>  

<head>
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
   
   <script src="js\jquery-3.1.1.min.js"></script> 
   
      
</head>
   
    
    
     <div class="modal-body">
    
      <div class="row">
            
            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">
            <table class="footable table " data-page-size="10" data-filter="#filter">
            
               <thead>
                <tr>
                    
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>RUT</th>
                    <th>Fono</th>
                    <th>Cargo</th>
                </tr>
                </thead>
                
               <tbody>
       
                <?php
                     $i=0;        
                     $condicion=false;              
                     foreach ($trabajadores as $row) {                        
                        $sql=mysqli_query($con,"select * from trabajador where idtrabajador='$row' ");
                        $result=mysqli_fetch_array($sql);
                        
                        $sql2=mysqli_query($con,"select * from cargos where idcargo='$cargos[$i]' ");
                        $result2=mysqli_fetch_array($sql2);
                                                
                        ?>
                               <tr>
                                  
                                  <td style=""><?php echo $result['idtrabajador'] ?></td>
                                  <td style=""><?php echo $result['nombre1'].' '.$result['nombre2'] ?></td>
                                  <td style=""><?php echo $result['apellido1'].' '.$result['apellido2'] ?></td>
                                  <td style=""><?php echo $result['rut'] ?></td>
                                  <td style=""><?php echo $result['telefono'] ?></td>
                                  <td style=""><?php echo $result2['cargo'] ?></td>
                              </tr>
                         
                 <?php $i++; } ?>
                
              </tbody>
              <tfoot>
                <tr>
                    <td colspan="6">
                        <ul class="pagination float-right"></ul>
                    </td>
                </tr>
              </tfoot>
           </table>
      </div>
   </div>

    <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

<script>

 $(document).ready(function() {
    
    $('.footable').footable();
    $('.footable2').footable();
            
});
</script>

        
        