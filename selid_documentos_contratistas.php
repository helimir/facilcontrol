<?php
session_start();
if (isset($_SESSION['usuario'])) {
   
        include('config/config.php');
        setlocale(LC_MONETARY,"es_CL");
        
       
        $doc=$_GET['doc'];
        $com=$_GET['com'];
        $contratista=$_GET['contratista'];
        $condicion=$_GET['condicion'];
        
        
        ?>  
        
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
  
        
    <div class="modal-body"> 
      <div class="row">
        <div class="form-group col-12  text-left">
            <label class="col-form-label" for="quantity"><b><span style="color: #FF0000;">(*)</span> LOS DOCUMENTOS CARGADOS SUSTITUYEN AL ANTERIOR <?php ?></b></label> 
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
                                 <span class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_contratista" name="carga_doc_contratista" accept="pdf" /></span>
                                 <span class="fileinput-filename"></span>
                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                             </div>
                       </td>
                       <td>
                            <button title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar_doc_contratista('<?php echo $doc  ?>','<?php echo $contratista  ?>','<?php echo $com  ?>',<?php echo $condicion  ?>)"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                       </td>
                    </tr>
              </tbody>
           </table>
      </div>
    </div>

 
 <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
 
 <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    


    

<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
} ?>       
        