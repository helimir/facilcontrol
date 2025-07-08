<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

session_destroy($_SESSION['active']);
if ($_SESSION['nivel']==3) {
    $_SESSION['active']=35;
} 
if ($_SESSION['nivel']==2) {
    $_SESSION['active']=28;
}    

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$query_mensajes=mysqli_query($con,"select * from mensajes where receptor='".$_SESSION['usuario']."'");
$cantidad=mysqli_num_rows($query_mensajes);

$query3=mysqli_query($con,"select * from mensajes where receptor='".$_SESSION['usuario']."' and estado=0 ");
$sinleer=mysqli_num_rows($query3);



?>

<!DOCTYPE html>
<html translate="no">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | <?php echo $_SESSION['titulo'] ?></title>

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

    <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
        
        <?php include('superior.php') ?> 

        <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-success compose-mail" href="">Redactar un Mensaje</a>
                            <div class="space-25"></div>
                            <h5>Carpetas</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="mensajes.php"> <i class="fa fa-inbox "></i> Bandeja Entradas <span class="label label-warning float-right"><?php echo $sinleer ?></span> </a></li>
                                <li><a href=""> <i class="fa fa-envelope-o"></i> Enviar Correo</a></li>
                                <li><a href="l"> <i class="fa fa-certificate"></i> Importantes</a></li>
                                <!--<li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger float-right">2</span></a></li>-->
                                <li><a href="> <i class="fa fa-trash-o"></i> Eliminados</a></li>
                            </ul>
                            <h5>Categorias</h5>
                            <ul class="category-list" style="padding: 0">
                                <li><a href="#"> <i class="fa fa-circle text-navy"></i> Categoria 1 </a></li>
                                <li><a href="#"> <i class="fa fa-circle text-danger"></i> Categoria 2</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Categoria 3</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-info"></i> Categoria 4</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Documentos (Doc)</a></li>
                            </ul>

                            
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

                <form method="get" action="" class="float-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="search" placeholder="Buscar un Correo" />
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-success">
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>
                <h2>
                    Bandeja Entrada (<?php echo $sinleer ?>)
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group float-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                    </div>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Actualizar"><i class="fa fa-refresh"></i> Actualizar</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Marcar como Leiso"><i class="fa fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Marcar como Importante"><i class="fa fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mover a Papelera"><i class="fa fa-trash-o"></i> </button>

                </div>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>
                <?php foreach ($query_mensajes as $row) { 
                    if ($row['estado']==0) {
                        $estado='unread';
                    }
                    if ($row['estado']==1) {
                        $estado='read';
                    } 
                    $query_mandante=mysqli_query($con,"select razon_social from mandantes where email='".$row['autor']."' ");
                    $result_mandante=mysqli_fetch_array($query_mandante);
                    
                    switch ($row['categoria']) {
                        case 0: $categoria='<span class="label label-warning float-right">Doc</span>';break;
                        case 1: $categoria='<span class="label label-navy float-right">Categoria 1</span>';break;
                        case 2: $categoria='<span class="label label-danger float-right">Categoria 2</span>';break;
                        case 3: $categoria='<span class="label label-primary float-right">Categoria 3</span>';break;
                        case 4: $categoria='<span class="label label-info float-right">Categoria 4</span>';break;
                    }
                    
                ?>                 
                    <tr class="<?php echo $estado ?>">
                        <td class="check-mail">
                            <input type="checkbox" class="i-checks">
                        </td>
                        <td class="mail-ontact"><a href="" onclick="detalle(<?php echo $row['id_mensaje']  ?>)"><?php echo $result_mandante['razon_social'] ?></a> <?php echo $categoria ?> </td>
                        <td class="mail-subject"><a href="" onclick="detalle(<?php echo $row['id_mensaje']  ?>)"><?php echo $row['mensaje'] ?></a></td>
                        <td class=""></td>
                        <td class="text-right mail-date"><?php echo substr($row['fecha'],10,6).'/'.substr($row['fecha'],0,10) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>
        <div class="footer">
                <div class="float-right">
                    Versi&oacute;n <strong>1.0</strong>
                </div>
                <div>
                    <strong>Copyright</strong> F&aacute;cil Control &copy; <?php echo $year ?>
                </div>
            </div>

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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        
        function detalle(id) {
          $.ajax({
            method: "POST",
            url: "add/ver_mensaje.php",
 			data:'id='+id,
 			success: function(data){
 			    window.location.href='detalle_mensaje.php';
 			}
        });  
        }
        
    </script>
</body>

</html>
<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>
