<?php
session_start();
if (isset($_SESSION['usuario'])) {
   
        include('config/config.php');
        setlocale(LC_MONETARY,"es_CL");
        
        $id=$_SESSION['verificar_id2'];
        $doc=$_GET['doc'];
        $com=$_GET['com'];
        $contrato=$_GET['contrato'];
        $mandante=$_GET['mandante'];
        $contratista=$_GET['contratista'];
        $query=mysqli_query($con,"select * from doc where id_doc='$doc' ");
        $result=mysqli_fetch_array($query);
        
        ?>  
        
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
  
        
    <div class="modal-body"> 
      <div class="row">
        <div class="form-group col-12  text-left">
            <label class="col-form-label" for="quantity"><b><span style="color: #FF0000;">(*)</span> LOS DOCUMENTOS CARGADOS SUSTITUYEN AL ANTERIOR <?php  ?></b></label> 
        </div>   
      </div>
      
      <div class="row">
            <table class="table" >
               <thead>
                <tr>
                    <th style="width: 80%;">Adjuntar <?php  ?></th>
                    <th style="width: 20%;">Accion</th>
                </tr>
               </thead>
               <tbody>
                       <tr>  
                        <td > 
                             <div  style="width:80%;background:" class="fileinput fileinput-new" data-provides="fileinput">
                                 <span   class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                 <span class="fileinput-exists">Cambiar</span><input  type="file" id="cargar_con" name="cargar_con" accept="pdf" /></span>
                                 <span class="fileinput-filename"></span>
                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                             </div>
                       </td>
                       <td>
                            <button title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $doc  ?>','<?php echo $com  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>')"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                       </td>
                    </tr>
              </tbody>
           </table>
      </div>
    </div>

 <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    
    <script>

    $(document).ready(function() {

            
                        
              // Bind normal buttons
                Ladda.bind( '.ladda-button',{ timeout: 2000 });
        
                // Bind progress buttons and simulate loading progress
                Ladda.bind( '.progress-demo .ladda-button',{
                    callback: function( instance ){
                        var progress = 0;
                        var interval = setInterval( function(){
                            progress = Math.min( progress + Math.random() * 0.1, 1 );
                            instance.setProgress( progress );
        
                            if( progress === 1 ){
                                instance.stop();
                                clearInterval( interval );
                            }
                        }, 200 );
                    }
                });
        
        
                var l = $( '.ladda-button-demo' ).ladda();
        
                l.click(function(){
                    // Start loading
                    l.ladda( 'start' );
        
                    // Timeout example
                    // Do something in backend and then stop ladda
                    setTimeout(function(){
                        l.ladda('stop');
                    },12000)
                });
            
    });
                                        

</script>

    

<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
} ?>       
        