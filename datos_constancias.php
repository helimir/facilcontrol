 
<?php
if ($tab>1) {
    $axu='preuba';
}

foreach ($conasig as $row) {
    $docum=mysqli_query($con,"select * from doc where id_doc='$row' ");
    $fdocum=mysqli_fetch_array($docum); ?>                    
    <div class="row"> 
        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label class="col-form-label" for="quantity"><strong><?php echo $fdocum['documento'].'-'.$axu   ?></strong> </label> 
        </div>
        <div style="background: #eeeeee; padding-top: 0.5%;" class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
           <div style="width: 100%;"  class="fileinput fileinput-new" data-provides="fileinput">
                <span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                <span class="fileinput-exists">Cambiar</span><input type="file" name="..."/></span>
                <span class="fileinput-filename"></span>
                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
            </div> 
        </div>
        <div class="form-group col-lg-6 col-md-2 col-sm-2 col-xs-2">
            <button type="button" class="btn-success btn btn-md" name="Subir" id="Subir" onclick=""><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button> 
            <button type="button" class="btn-primary btn btn-md" name="Subir" id="Subir" onclick=""><i class="fa fa-download" aria-hidden="true"></i> Descargar</button> 
            <button type="button" class="btn-danger btn btn-md" name="Subir" id="Subir" onclick=""><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
        </div>
        <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
            
        </div>
        <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
            
        </div>
    </div>
                                                        
    <br/>
                                                          
<?php } ?>               
                            