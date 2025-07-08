<?php

/**
 * @author lolkittens
 * @copyright 2022
 */

session_start();
include('config/config.php');


?>

 <!-- Sweet Alert -->
 <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />

<form  method="post" id="frmFechaPlan"> 
    <div class="modal-body">
      
      <div class="row">
           <p>Fecha Fin Plan: <b><?php echo $_GET['fecha'] ?></b> </p>
      </div>
    
      <div class="row">
           <input type="date" name="fecha_val" id="fecha_val" class="form-control" value="0000-00-00" />
           <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
      </div>
      
   </div>
   <div class="modal-footer">
            <a style="color: #fff;" class="btn btn-danger btn-sm" data-dismiss="modal" >Cerrar</a>
            <a style="color: #fff;" class="btn btn-success btn-sm" href="" onclick="fecha_val()" >Actualizar</a>
  </div>
</form> 

<!-- Mainly scripts -->
    
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>
    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>
     <!-- iCheck -->
    

<!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    <script>
  
     
    function fecha_val() {
          var valores=$('#frmFechaPlan').serialize();
            $.ajax({
    			method: "POST",
                url: "add/fecha_plan.php",
                data: valores,
    			success: function(data){			  
                 if (data==0) {
                    swal({
                       title:"Fecha Editada",
                       text: "Fecha Fin de Plan",
                       type: "success"
                    });
                    setTimeout(function(){ window.location.href='list_contratistas.php'},8000);
    			  } else {
    			    swal({
                        title: "Fecha No Asignada",
                        text: "Vuelva a intentar",
                        type: "error"
                    }); 
    			  }
    			}                
           });
         }
  </script>       