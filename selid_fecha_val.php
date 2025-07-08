<?php

/**
 * @author lolkittens
 * @copyright 2022
 */

session_start();
include('config/config.php');


?>

 <style>
 
 input[type=checkbox]
{
  /* Doble-tamaño Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari y Chrome */
  -o-transform: scale(2); /* Opera */
  padding: 10px;
}

/* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificación */
.checkboxtexto
{
  /* Checkbox texto */
  font-size: 80%;
  display: inline;
}
 
 </style> 
 <!-- Sweet Alert -->
 <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
 <link href="css\plugins\iCheck\custom.css" rel="stylesheet">

<form  method="post" id="frmAsignar"> 
    <div class="modal-body">
    
      <div class="row">
           <input type="date" name="fecha_val" id="fecha_val" class="form-control" value="0000-00-00" />
           <input type="hidden" name="id" value="<?php echo $_SESSION['verificar_id'] ?>" />
      </div>
      <br />
      <div class="row">
           <div style="margin-left: 2%;"> <input style="" class="checkboxtexto" name="indefinido" type="checkbox" value="1" onclick="deshabilitar_fecha()" /> <span style="color: #FF0000;font-weight: bold;font-size: 16px;">&nbsp;&nbsp;Indefinido</span> </div>
      </div>
   </div>
   <div class="modal-footer">
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
            <a style="color: #fff;" class="btn btn-success" href="" onclick="fecha_val()" >Guardar</a>
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
    
        
     $(document).ready(function () {
                
                
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                }); 
      });          
    
    function deshabilitar_fecha() {
        $('#fecha_val').prop('disabled','disabled');        
    }
     
    function fecha_val() {
          var valores=$('#frmAsignar').serialize();
            $.ajax({
    			method: "POST",
                url: "add/fecha_val.php",
                data: valores,
    			success: function(data){			  
                 if (data==0) {
                    //swal({
                      //  title:"Procesado",
                       // text: "Documentos Verificados",
                       // type: "success"
                    //});
                    //setTimeout(function(){ window.location.href='verificar_documentos_mandante.php'},2000);
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