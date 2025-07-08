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

$query_mensajes=mysqli_query($con,"select * from mensajes where id_mensaje='".$_SESSION['mensaje']."'");
$result_mensaje=mysqli_fetch_array($query_mensajes);

$query_mandante=mysqli_query($con,"select razon_social, email from mandantes where email='".$result_mensaje['autor']."' ");
$result_mandante=mysqli_fetch_array($query_mandante);



?>

<!DOCTYPE html>
<html translate="no">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facil Control | Mensajes</title>

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
                                <li><a href=""> <i class="fa fa-certificate"></i> Importantes</a></li>
                                <!--<li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger float-right">2</span></a></li>-->
                                <li><a href=""> <i class="fa fa-trash-o"></i> Eliminados</a></li>
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
                <div class="float-right tooltip-demo">
                    <a href="mail_compose.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Repuesta</a>
                    <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Print email"><i class="fa fa-print"></i> </a>
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
                </div>
                <h2>
                   Ver Mensaje
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">


                    <h3>
                        <span class="font-normal">Asunto: </span><?php echo $result_mensaje['asunto'] ?>.
                    </h3>
                    <h5>
                        <span class="float-right font-normal">10:15AM 02 FEB 2014</span>
                        <span class="font-normal">De: </span><?php echo $result_mandante['razon_social'].' ('.$result_mandante['email'].')' ?>
                    </h5>
                </div>
            </div>
                <div class="mail-box">


                <div style="" class="mail-body">
                    <p><?php echo $result_mensaje['mensaje'] ?></p>
                </div>
                  
                        <!--<div class="mail-body text-right tooltip-demo">
                                <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-reply"></i> Res</a>
                                <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-arrow-right"></i> Forward</a>
                                <button title="" data-placement="top" data-toggle="tooltip" type="button" data-original-title="Print" class="btn btn-sm btn-white"><i class="fa fa-print"></i> Print</button>
                                <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</button>
                        </div>
                        <div class="clearfix"></div>-->


                </div>
            </div>
        </div>
        </div>
        <div class="footer">
                <div class="float-right">
                    Versi&oacute;n <strong>1.0</strong>
                </div>
                <div>
                    <strong>Copyright</strong> Proyecto &copy; <?php echo $year ?>
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
    </script>
</body>

</html>
<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>
