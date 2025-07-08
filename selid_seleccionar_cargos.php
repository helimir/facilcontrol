<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL"); 

$query=mysqli_query($con,"select * from cargos  ");


?>        
<form method="post">     
<div class="modal-body">
      
        <div style="overflow-y: auto;" class="row">
           <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                <table class="table" >
                    <tbody>
                    <?php $i=1; foreach ($query as $row) {    ?>
                        <tr>                            
                            <td style="width: 2%;"><div class=""> <input class="form-control" id="cargo" name="cargos[]" type="checkbox" value="<?php echo $row['idcargo'] ?>" /> </div></td>
                            <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['cargo'] ?></label></td>
                            
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                <!--<select  name="cargos[]" id="cargos" multiple="" class=" form-control"  >
                <?php
                     while($row = mysqli_fetch_assoc($query)) { ?>
                     <option value="0"><?php echo $row['cargo'] ?></option>                             
                    <?php  } ?> 
                </select>-->
            </div>                    
        </div>
    
</div>
   
<div class="modal-footer">
    <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
    <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
    <input style="color: #fff;" class="btn btn-success" type="submit" name="asignar" value="asignar"  />
</div>
</form>    
<script>
    function asignar() {
        var valor=$('#cargo').val();
        alert(valor);
    }
</script>

<?php

if (isset($_POST['asignar'])) {
    if (is_array($_POST['cargos'])) {
        $selected = '';
        $num_cargos = count($_POST['cargos']);
        $current = 0;
        foreach ($_POST['cargos'] as $key => $value) {
            if ($current != $num_cargos-1)
                $selected .= $value.', ';
            else
                $selected .= $value.'.';
            $current++;
        }
    }
    else {
         
        $selected = 'Debes seleccionar Cargos';
    }

    $_SESSION['cargos']=$selected;
}   

?>

