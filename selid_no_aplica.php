<?php
session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    

    $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$_GET['doc']."' "); 
    $result=mysqli_fetch_array($sql);
    $contratista=$_SESSION["contratista"];
    
    
?>    
   <div class="modal-body">
        <div class="row">
            <div class="col-12">
               <h3 class="form-label"><?php echo $result['documento'] ?> </h3>
            </div>            
        </div>
        <div class="row">
            <div class="col-12">
               <input class="form-control" id="mensaje_na" name="mensaje_na" type="text"  />
            </div>            
        </div>
   </div>
   
   <div class="modal-footer">        
            <a style="color: #282828;" class="btn btn-default btn-sm"  onclick="cerrar_no_aplica(<?php echo $_GET['num'] ?>)" >Cancelar</a>    
            <a style="color: #fff;" class="btn btn-success btn-sm" onclick="guardar_no_aplica(<?php echo $contratista ?>,<?php echo $_GET['doc'] ?>)" >Guardar</a>
   </div>

<script>
  
   function guardar_no_aplica(contratista,doc) {
       var mensaje_nax=$("#mensaje_na").val();
      //var mensaje_na=document.getElementById("mensaje_na").value;
      if (mensaje_nax=='') {
            swal({
               title: "Debe ingresar un mensaje",
               //text: "Un Documento no validado esta sin comentario",
               type: "warning"
            })
      } else {
         $.ajax({
            method: "POST",
            url: "add/addnoaplica.php",
            data:'contratista='+contratista+'&doc='+doc+'&mensaje='+mensaje_na, 
            success: function(data){
                  if (data==0) {
                        $("#modal_no_aplica").modal('hide');
                        swal({
                           title: "Mensaje Guardado",
                           //text: "Un Documento no validado esta sin comentario",
                           type: "success"
                        })
                  } else {
                     
                  }
            }   
         });
      }
   }   

    $(document).ready(function (){
         $("#modal_no_aplica").on('hidden.bs.modal', function () {  
         $("#modal_modal_no_aplica").modal('hide');
         $("#aplica"+<?php echo $_GET['num'] ?>).prop("checked", false);
      });
    });
</script>

