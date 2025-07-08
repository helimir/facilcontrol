<?php 
session_start();
if (isset($_SESSION['usuario'])) { 
include('../config/config.php');

$query=mysqli_query($con,"select t.nombre_epp, e.* from epp as e Left Join tipo_epp as t On t.id_tipo=e.tipo where e.id_epp='".$_GET['epp']."'  ");
$result=mysqli_fetch_array($query);

$query_tipo_epp=mysqli_query($con,"select * from tipo_epp where estado=0  ");
?>
                    
                    <div class="modal-body">  
                        
                                        <div class="row from-group"> 
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Nombre</b></label>                 
                                            <div class="col-lg-9 col-sm-9">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="nombre_epp_e" id="nombre_epp_e" value="<?php echo $result['epp']  ?>" />
                                            </div>                                
                                        </div>
                                        
                                        <div style="margin-top:1.5%" class="row from-group"> 
                                            <label class="col-lg-3 col-form-label fondo"><b>Tipo</b></label>
                                            <div class="col-lg-9 col-sm-9">
                                                <select style="border:1px solid #969696" id="tipo_epp" name="tipo_epp" class="form-control">
                                                <option value="<?php echo $result['id_epp']  ?>" selected=""><?php echo $result['nombre_epp']  ?></option>
                                                <?php
                                                    foreach ($query_tipo_epp as $row){
                                                        echo '<option value="'.$row['id_tipo'].'" >'.$row['nombre_epp'].'</option>';
                                                    }    
                                                ?>     
                                                </select>
                                                
                                            </div>                                
                                        </div>  
                                        
                                        <div style="margin-top:1.5%" class="row">
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Marca </b></label>                                 
                                            <div class="col-lg-9 col-sm-9">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="marca_epp" id="marca_epp" placeholder="" value="<?php echo $result['marca']  ?>" />
                                            </div>                                
                                        </div>

                                        <div style="margin-top:1.5%" class="row">
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Modelo </b></label>                                 
                                            <div class="col-lg-9 col-sm-9">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="modelo_epp" id="modelo_epp" placeholder="" value="<?php echo $result['modelo']  ?>" />
                                            </div>                               
                                        </div>

                                        <div style="margin-top:1.5%" class="row">
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Documento </b></label>                                 
                                            <div class="col-lg-9 col-sm-9">
                                                <?php if (empty($result['url_epp'])) { ?>
                                                    <span>SIN DOCUMENTO EPP</span>
                                                <?php } else { ?>
                                                    <a href="<?php echo $result['url_epp'] ?>" target="_BLACK">Documento EPP</a>
                                                    
                                                <?php } ?>
                                            </div>                               
                                        </div>
                                        
                                                                        
                                        <div style="margin-top:4%" style="margin-top:2%" class="row">                                     
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Nuevo</b></label>                                     
                                            <div style="" class="col-lg-9 col-sm-9">
                                                    <div style="width: 100%;background: #292929;color:#fff;padding: 1% 0%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento (opcional)</span>
                                                        <span  class="fileinput-exists">Cambiar</span><input  type="file" name="archivo_nuevo" id="archivo_nuevo" accept="application/pdf"  /></span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </div>                    
                                            </div>
                                        </div>
                                
                    </div>  
                    
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                        <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="editar(<?php echo $_GET['epp'] ?>,<?php echo $_GET['contratista'] ?>)">Editar EPP</button>
                    </div>          
                    
                    


 <script>
   

  
                                    function editar(idepp,contratista) {
                                        var epp_e=document.getElementById('nombre_epp_e').value;
                                        var tipo=$('#tipo_epp').val();
                                        var marca=$('#marca_epp').val();
                                        var modelo=$('#modelo_epp').val();      
                                        alert(epp_e)
                                        var formData = new FormData(); 
                                        var files= $('#archivo_nuevo')[0].files[0];                   
                                        formData.append('archivo',files);
                                        formData.append('epp',epp_e);
                                        formData.append('idepp',idepp);
                                        formData.append('tipo', tipo);
                                        formData.append('marca', marca);
                                        formData.append('modelo', modelo );
                                        formData.append('contratista', contratista );
                                        
                                        if (epp_e!="") {
                                            if (tipo!="0") {   
                                                if (marca!="") {
                                                    if (modelo!="") {
                                                            //alert(contratista+' '+epp+' '+tipo+' '+marca+' '+modelo) 
                                                            $.ajax({
                                                                        url: 'add/editar_epp.php',
                                                                        type: 'post',
                                                                        data:formData,
                                                                        contentType: false,
                                                                        processData: false,
                                                                        beforeSend: function(){

                                                                            const progressBar = document.getElementById('myBar');
                                                                            const progresBarText = progressBar.querySelector('.progress-bar-text');
                                                                            let percent = 0;
                                                                            progressBar.style.width = percent + '%';
                                                                            progresBarText.textContent = percent + '%';
                                                                                
                                                                            let progress = setInterval(function() {
                                                                                if (percent >= 100) {
                                                                                        clearInterval(progress);                                                                                                       
                                                                                    } else {
                                                                                        percent = percent + 1; 
                                                                                        progressBar.style.width = percent + '%';
                                                                                        progresBarText.textContent = percent + '%';
                                                                                    }
                                                                            }, 100);
                                                                            $('#modal_cargar').modal('show');						
                                                                        },
                                                                        success: function(data){
                                                                            $('#modal_cargar').modal('hide');
                                                                            if (data==0) {
                                                                                swal({
                                                                                    title: "EPP Creado",
                                                                                    //text: "You clicked the button!",
                                                                                    type: "success"
                                                                                });
                                                                                window.location.href='crear_epp.php';
                                                                                                            
                                                                            } else {                                             
                                                                                    swal({
                                                                                        title: "Disculpe Error de Sistema",
                                                                                        text: "Vuelva a Intentar",
                                                                                        type: "error"
                                                                                    });
                                                                            }
                                                                        },
                                                                        complete:function(data){                                        
                                                                        $('#modal_cargar').modal('hide');
                                                                            }, 
                                                                        error: function(data){
                                                                        }
                                                                });   
                                                            
                                                    } else {
                                                        swal({
                                                            title: "Modelo del EPP",
                                                            text: "Falta Modelo del EPP",
                                                            type: "warning"
                                                            
                                                        });
                                                    }        
                                                } else {
                                                        swal({
                                                            title: "Marca del EPP",
                                                            text: "Falta Marca del EPP",
                                                            type: "warning"
                                                            
                                                        });
                                                }                 
                                            } else {
                                                swal({
                                                    title: "Seleccionar Tipo EPP",
                                                    text: "Falta tipo de EPP",
                                                    type: "warning"
                                                    
                                                });
                                            }        
                                        } else {
                                            swal({
                                                title: "Nombre del EPP",
                                                text: "Falta nombre epp",
                                                type: "warning"                
                                            });
                                        }  
                                        					
                                    }
                            

</script>



 
<?php } else { 

echo "<script> window.location.href='../admin.php'; </script>";
}