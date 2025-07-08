<?php
session_start();
if (isset($_SESSION['usuario'])) {

        include('config/config.php');
        setlocale(LC_MONETARY,"es_CL");
        $dia=date('d');
        $mes1=date('m');
        $year=date('Y');

        $id=$_SESSION['trabajador'];
        $idcargo=$_SESSION['cargo'];
        $perfil=$_SESSION['perfil'];
        $id_obs=0;
        $contratista=$_SESSION['contratista'];
        $mandante=$_SESSION['mandante'];
        $contrato=$_SESSION['contrato'];

        if ($_SESSION['mandante']==0) {
        $razon_social="INACTIVO";     
        } else {
            $query_m=mysqli_query($con,"select * from mandantes where id_mandante='$mandante' ");
            $result_m=mysqli_fetch_array($query_m);
            $razon_social=$result_m['razon_social'];
        }

        $query_trabajador=mysqli_query($con,"select a.url_foto as foto_asignada, t.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador where t.idtrabajador='".$_SESSION['trabajador']."' and a.contrato='$contrato' ");
        $result_trabajador=mysqli_fetch_array($query_trabajador);
        $rut=$result_trabajador['rut'];

        $query_perfil_cargo=mysqli_query($con,"select * from perfiles_cargos where contrato='".$_SESSION['contrato']."' ");
        $result_perfil_cargo=mysqli_fetch_array($query_perfil_cargo);


        $query_contrato=mysqli_query($con,"select o.razon_social, o.rut, c.* from contratos as c LEFT JOIN contratistas as o On o.id_contratista=c.contratista where c.id_contrato='".$_SESSION['contrato']."' ");
        $result_contrato=mysqli_fetch_array($query_contrato);

        $query_cargos=mysqli_query($con,"select * from cargos where idcargo='".$_SESSION['cargo']."' ");
        $result_cargo=mysqli_fetch_array($query_cargos);


        $cargos=unserialize($result_perfil_cargo['cargos']);
        $perfiles=unserialize($result_perfil_cargo['perfiles']);

        $query_obs=mysqli_query($con,"select o.*, t.url_foto from observaciones as o left join trabajador as t On t.idtrabajador=o.trabajador where o.contrato='".$_SESSION['contrato']."' and o.trabajador='".$_SESSION['trabajador']."' and o.estado!='2' ");
        $result_obs=mysqli_fetch_array($query_obs);
        if (isset($result_obs['id_obs'])) {$id_obs=$result_obs['id_obs'];} 
        if (isset($result_obs['verificados'])) { $list_veri=unserialize($result_obs['verificados']) ;} 
        
        

        $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='$id' and contrato='".$_SESSION['contrato']."' and estado!='2'  ");
        $result_ta=mysqli_fetch_array($query_ta);
        if (isset($result_ta['documentos'])) {
            $doc_ta=unserialize($result_ta['documentos']);
        }
        $existe_acreditado=mysqli_num_rows($query_ta);

        $contador=0;
        foreach ($cargos as $row) {    
            if ($row==$idcargo) {
                    $posicion_cargo=$contador;
                    break;
                }    
            $contador++;
        }

        $contador=0;
        foreach ($perfiles as $row) {    
            if ($contador==$posicion_cargo) {
                    //$perfil=$row;
                    break;
                }    
            $contador++;
        }


        $query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
        $result_doc=mysqli_fetch_array($query_doc); 
        $doc=unserialize($result_doc['doc']);

        ?>  

        <!DOCTYPE html>
        <meta name="google" content="notranslate" />
        <html lang="es-ES">

        <head>
            <meta http-equiv='cache-control' content='no-cache'>
            <meta http-equiv='expires' content='0'>
            <meta http-equiv='pragma' content='no-cache'>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>FacilControl | Documentos Trabajador</title>
            <meta content="" name="description">
            <meta content="" name="keywords">

            <!-- Favicons -->
            <link href="assets/img/favicon.png" rel="icon">
            <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

            
            <link href="css\bootstrap.min.css" rel="stylesheet">
            <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
            <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
            <link href="css\animate.css" rel="stylesheet">
            <link href="css\style.css?n=1" rel="stylesheet">

            <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
            <!-- Sweet Alert -->
            <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
            
            <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
            <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
            <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
            <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

          
            
            
        <!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>-->
            

        <script src="js\jquery-3.1.1.min.js"></script>
        
        <script>
        
        function regresar(url){
                window.location.href=url;
        }

        function subir_foto(contratista) {
            //alert(contratista);
            var fileInput = document.getElementById('foto');
            var filePath = fileInput.files.length;
            if (filePath>0 ) {
                        var rut=$('#rut').val();
                        var formData = new FormData(); 
                        var files= $('#foto')[0].files[0];                   
                        formData.append('foto',files);
                        formData.append('contratista',contratista);
                        formData.append('rut',rut);
                    alert('p')
            } else {
            swal({
                title: "Sin Archivo",
                text: "Debe Seleccionar una Imagen",
                type: "error"
            });    
            }    
        }  
        
        // funcion que procesa los documentos
        function cargar_doc_trabajador(cant,rut_t,nom_contrato){
                
                var trabajador=$('#trabajador').val();
                var extension=true;
                var contador=0;
                var contador2=0;
                var arreglo_existe=[];
                var arreglo_doc_e=[];
                //alert(rut_t+' '+nom_contrato);
                
                for (i=0;i<=cant-1;i++) {
                    var filename = $('#carga_doc_t'+i).val();
                    var existe_input=$('#doc_existe'+i).val();
                        
                    if (filename!='') {
                        contador++;    
                    }
                    if (existe_input==1) {
                        arreglo_existe.push(existe_input);
                        var valor_doc_e=$('#cadena_doc'+i).val();
                        arreglo_doc_e.push(valor_doc_e);
                            
                        contador2++;
                    } else {
                        existe_input=0;
                        arreglo_existe.push(existe_input);   
                    }
                }
                //alert(arreglo_existe)            
                if (contador>0 || contador2>0) {                        
                                var arreglo_doc=[];
                                var arreglo_com=[];
                                var arreglo_fil=[];
                                var formData = new FormData();                        
                                                    
                                for (i=0;i<=cant-1;i++) {                            
                                    var filename = $('#carga_doc_t'+i).val();
                                    if (filename!='') {
                                        var valor_doc=$('#cadena_doc'+i).val();
                                        arreglo_doc.push(valor_doc);
                                        
                                        var valor_com=$('#comentario'+i).val();
                                        arreglo_com.push(valor_com);                               
                                    
                                        formData.append('carga_doc_t[]',$('#carga_doc_t'+i)[0].files[0]);                                  
                                    } 
                                }
                                
                                var doc=JSON.stringify(arreglo_doc);
                                formData.append('doc', doc );
                                
                                var doc_e=JSON.stringify(arreglo_doc_e);
                                formData.append('doc_e', doc_e );
                                
                                var com=JSON.stringify(arreglo_com);
                                formData.append('com', com );
                                
                                var existe_doc=JSON.stringify(arreglo_existe);
                                formData.append('existe_doc', existe_doc );
                                
                                //cantidad de documentos
                                formData.append('cant', cant );
                                
                                //rut del trabajador
                                formData.append('rut_t', rut_t );
                                
                                //rut del trabajador
                                formData.append('nom_contrato', nom_contrato );
                                
                                //trabajador
                                formData.append('trabajador', trabajador );
                                
                                //alert(doc+' '+doc_e);
                                
                                $.ajax({
                                        url: 'cargar_documentos_trabajador.php',
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
                                        success: function(data) {
                                            
                                            if(data== 0){
                                                //alert(data);
                                                $('#modal_cargar').modal('hide');
                                                //swal({
                                                //        title: "Documento Enviado",
                                                        //text: "Un Documento no validado esta sin comentario",
                                                //        type: "success"
                                                //    });
                                                window.location.href='verificar_documentos_trabajador_contratista.php';
                                            } else {
                                                //alert(data);
                                                $('#modal_cargar').modal('hide');  
                                                swal({
                                                        title: "Documeto No Cargado",
                                                        text: "Vuelva a intetar",
                                                        type: "error"
                                                });  
                                            } 
                                        },
                                        complete:function(data){
                                            $('#modal_cargar').modal('hide');
                                        }, 
                                        error: function(data){
                                            $('#modal_cargar').modal('hide');
                                        }
                                }); 
            } else {
                swal({
                    title: "Sin Documento(s) Seleccionado",
                    text: "Debe adjuntar al menos un Documento",
                    type: "warning"
                });
            }                 
                            
            }
            
            function seldoc(id) {
                //document.getElementById("doc_existe"+id).disabled = document.getElementById("carga_doc_t"+id).checked;
                //var valor= $('#doc_existe'+id).val();
                
                var seleccionado =$('#doc_existe'+id).prop('checked');
                if (seleccionado) {                    
                    $('#doc_existe'+id).val(1);
                } else {
                    const p=document.getElementById("texto"+id);
                    p.innerText="Seleccione Documento";
                    //$('#carga_doc_t'+id).prop('disabled',false);
                }
            }

    

        function cambiar_foto(rut,contrato,trabajador,perfil) {
                var formData = new FormData(); 
                var files= $('#foto')[0].files[0];                   
                formData.append('foto',files);
                formData.append('rut',rut);
                formData.append('contrato',contrato);
                formData.append('trabajador',trabajador);
                formData.append('perfil',perfil);
                var num_foto=$('#num_foto').val();
                var archivo = document.getElementById("foto").files[0];
                var reader = new FileReader();
                $.ajax({
                    url: 'cargar/cambiar_fotos_trabajador.php',
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
                    success: function(response) {
                        if (response==0) {
                            swal({
                                title: "Foto Actualizada",
                                //text: "Dimensiones no validas",
                                type: "success"
                            });
                            document.getElementById('btn-agregar').innerHTML='Foto Cambiada';
                            reader.readAsDataURL(archivo );
                            reader.onloadend = function () {
                                document.getElementById("foto_cambiada").src = reader.result;
                            }

                        } 
                        // no se cargo imagen
                        if (response==1) {
                            swal({
                                title: "Foto No se Cargo",
                                text: "Vuelva a intentar",
                                type: "error"
                            });           
                        } 
                        // tipo no permitido
                        if (response==2) {
                            swal({
                                title: "Tipo Archivo No permitido",
                                text: "Debe adjuntar un archivo tipo imagen",
                                type: "warning"
                            });  
                        }
                         
                    },
                    complete:function(data){
                        $('#modal_cargar').modal('hide');
                    }, 
                    error: function(data){
                        $('#modal_cargar').modal('hide');
                    }
                });
        }

    function agregar_foto_contrato(trabajador,contrato,contratista,mandante,cargo,perfil,rut) {
        var formData = new FormData(); 
        var files= $('#foto')[0].files[0];                   
        formData.append('foto',files);
        formData.append('trabajador',trabajador);
        formData.append('contrato',contrato);
        formData.append('contratista',contratista);
        formData.append('mandante',mandante);
        formData.append('cargo',cargo);
        formData.append('perfil',perfil);
        formData.append('rut',rut);
        var num_foto=$('#num_foto').val();
        var archivo = document.getElementById("foto").files[0];
        var reader = new FileReader();
        $.ajax({
            url: 'cargar/cargar_fotos_contrato.php',
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
            success: function(data) {   
                        $('#modal_cargar').modal('hide');
                        if (data==0) {
                            swal({
                                title: "Foto Agregada",
                                //text: "Dimensiones no validas",
                                type: "success"
                            });
                            document.getElementById('btn-agregar').innerHTML='Foto Agregada';
                            
                            $('#estado'+num_foto).removeAttr('class');
                            $('#estado'+num_foto).attr('class','bg-info p-xxs');                                                                
                            document.getElementById('estado'+num_foto).innerHTML='<b style="font-14px">EN PROCESO</b>'; 

                            reader.readAsDataURL(archivo );
                            reader.onloadend = function () {
                                document.getElementById("foto_agregada_nueva").src = reader.result;
                            }
                        } else {
                          
                            swal({
                                title: "Error de Sistema",
                                text: "Vuelva a intentar",
                                type: "error"
                            });           
                           
                        } 
            },
            complete:function(data){
                $('#modal_cargar').modal('hide');
            }, 
            error: function(data){
                $('#modal_cargar').modal('hide');
            }
        });
    }

    function agregar_foto_al_contrato(trabajador,contrato,contratista,mandante,cargo,perfil,rut) {
        var formData = new FormData();         
        formData.append('trabajador',trabajador);
        formData.append('contrato',contrato);
        formData.append('contratista',contratista);
        formData.append('mandante',mandante);
        formData.append('cargo',cargo);
        formData.append('perfil',perfil);
        formData.append('rut',rut);
        var num_foto=$('#num_foto').val();
        $.ajax({
            url: 'cargar/cargar_fotos_al_contrato.php',
            type: 'post',
            data:formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data==0) {                                          
                    swal({
                        title: "Foto Agregada",
                        //text: "Dimensiones no validas",
                        type: "success"
                    });                                               
                    document.getElementById('btn-agregar').innerHTML='Foto Agregada';
                    $('#estado'+num_foto).removeAttr('class');
                    $('#estado'+num_foto).attr('class','bg-info p-xxs');                                                                
                    document.getElementById('estado'+num_foto).innerHTML='<b style="font-14px">EN PROCESO</b>'; 
                    
                } else {  
                    swal({
                        title: "Error de Sistema",
                        text: "Vuelva a intentar",
                        type: "error"
                    });    
                } 
            }
        });        
    }

    function cerrar_no_aplica() {
        var num=$("#num_na").val();        
        $("#modal_no_aplica").modal('hide');
        $("#aplica"+num).prop("checked", false);
    }

    function guardar_no_aplica(mandante) {        
      var num=$("#num_na").val();
      var doc=$("#doc_na").val();  
      var contratista=$("#contratista_na").val();    
      var contrato=$("#contrato_na").val();
      var mensaje_nax=$("#mensaje_na").val();  
      var trabajador=$("#trabajador_na").val();
      var rut=$("#rut_na").val();   
      var documento=$("#documento_na").val();     
      var estado=$("#estado_doc"+num).val();
      //alert(num)
      if (mensaje_nax=='') {
            swal({
               title: "Debe ingresar un mensaje",
               //text: "Un Documento no validado esta sin comentario",
               type: "warning"
            })
      } else {
         
         $.ajax({
            method: "POST",
            url: "add/addnoaplica_trabajador.php",
            data:'contratista='+contratista+'&doc='+doc+'&mensaje='+mensaje_nax+'&mandante='+mandante+'&contrato='+contrato+'&trabajador='+trabajador+'&rut='+rut, 
            success: function(data){
                $("#modal_no_aplica").modal('hide');
                        $("#modal_no_aplica").on('hidden.bs.modal', function () {   
                            $("#aplica"+num).attr("checked",true);
                });
                $("#aplica"+num).attr("checked",true);
                if (data==0) {
                        swal({
                            title: "Documento Enviado",
                            //text: "Un Documento no validado esta sin comentario",
                            type: "success"
                        });

                         //sin documento
                         if (estado==1) {
                            var url='doc/temporal/'+mandante+'/'+contratista+'/contrato_'+contrato+'/'+rut+'/'+documento+'_'+rut+'.pdf';
                            $('#td_documento'+num).attr('href', url);
                            document.getElementById('td_documento'+num).innerHTML='<a target="_BLACK" href="'+url+'">'+documento+'</a>';                        
                        
                            $('#estado'+num).removeAttr('class');
                            $('#estado'+num).attr('class','bg-info p-xxs');                                                                
                            document.getElementById('estado'+num).innerHTML='<b style="font-14px">EN PROCESO</b>'; 

                            
                        }    

                        // documento en observacion
                        if (estado==3) {                            
                            // cambiar estado a EN PROCESO                                                  
                            $('#estado'+num).removeAttr('class');
                            $('#estado'+num).attr('class','bg-info p-xxs');                                                                
                            document.getElementById('estado'+num).innerHTML='<b style="font-14px">EN PROCESO</b>';
                            // quitar mensaje 
                            document.getElementById('mensaje'+num).innerHTML='';
                        }  
                        
                  } else {
                    swal({
                        title: "Disculpe, Error de Sistema",
                        text: "Vuelva a Intentar",
                        type: "warning"
                    })
                  }
            }   
         });
      }
   }  


        function prueba(num) {
            var estado=$("#estado_doc"+num).val();
            swal({
                title: "Sustituir Documento No Aplica",
                text: "El nuevo documento sustituye al anterior",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, sustituir",
                closeOnConfirm: false
            }, function () {
             
                if (estado==1) {
                    //document.getElementById('div_seleccionar2'+num).style.display='none'
                    //document.getElementById('div_seleccionar'+num).style.display='block';
                    //document.getElementById('span_seleccionar'+num).style.backgroundColor='#F8AC59';
                } else {
                    document.getElementById('div_seleccionar'+num).remove();
                    document.getElementById('div_seleccionar2'+num).style.display='block';

                }
                
                swal("Confirmado, continuar con Seleccion de Archivo", "", "success");
            });
        }

        function seleccionar(num) { 
            var isChecked = $('#aplica'+num).prop('checked');
            if (isChecked) {
                    //$('#carga_doc_t'+num).removeAttr('type');
                    swal({
                        title: "Sustituir Documento No Aplica",
                        text: "El nuevo documento sustituye al anterior",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Si, sustituir",
                        closeOnConfirm: false
                    }, function () {   
                            document.getElementById('div_seleccionar2'+num).remove();
                            document.getElementById('div_seleccionar'+num).style.display='block';
                            //document.getElementById('span_seleccionar'+num).style.backgroundColor='#F8AC59';               
                        
                        swal("Confirmado, continuar con Seleccion de Archivo", "", "success");
                    });
            }
        }

    </script> 
        
        
    <style>
                .estilo {
                    display: inline-block;
                    content: "";
                    width: 15px;
                    height: 15px;
                    margin: 0.5em 0.5em 0 0;
                    background-size: cover;
                }
                .estilo:checked  {
                    content: "";
                    width: 15px;
                    height: 15px;
                    margin: 0.5em 0.5em 0 0;
                }
                
                .estilo2 {
                    display: inline-block;
                    content: "";
                    width: 10px;
                    height: 10px;
                    margin: 0.5em 0.5em 0 0;
                    background-size: cover;
                }
                .estilo2:checked  {
                    content: "";
                    width: 10px;
                    height: 10px;
                    margin: 0.5em 0.5em 0 0;
                }
                
                input[type=checkbox]
                {
                /* Doble-tama�o Checkboxes */
                -ms-transform: scale(2); /* IE */
                -moz-transform: scale(2); /* FF */
                -webkit-transform: scale(2); /* Safari y Chrome */
                -o-transform: scale(2); /* Opera */
                padding: 10px;
                }
                
                /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
                .checkboxtexto
                {
                /* Checkbox texto */
                font-size: 80%;
                display: inline;
                }

                

        .loader {
            position: relative;
            text-align: center;
            margin: 15px auto 35px auto;
            z-index: 9999;
            display: block;
            width: 80px;
            height: 80px;
            border: 10px solid rgba(0, 0, 0, .3);
            border-radius: 50%;
            border-top-color: #1C84C6;
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
        }  

        .fondo {
            background:#e9eafb;
            color:#292929;
            border-bottom: #fff 2px solid;
            border-left: #fff 2px solid;
            width:15%;
        }

        .fondo_td {
            background:#e9eafb;
            width: 20%;
        }

        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }

           
        
        hr {
        height: 0.3px;
        background-color: #B9B9B9;
        }

        .cambiar span:hover {
            background:#8a5a2e;
        }

        .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }

                
            
        </style>
        
        </head>



        <body>

            <div id="wrapper">

                <?php include('nav.php') ?>

                <div id="page-wrapper" class="gray-bg">
            
                <?php include('superior.php') ?> 
                
            
                    <div style="" class="row wrapper white-bg ">
                        <div class="col-lg-10">
                            <h2 style="color: #010829;font-weight: bold;">DOCUMENTOS DEL TRABAJADOR <?php #echo $id  ?></h2>
                            <label class="label label-warning encabezado">Mandante: <?php echo $result_m['razon_social'].' - '.$result_m['rut_empresa'] ?></label>
                        </div>
                    </div>
            
                <div class="wrapper wrapper-content animated fadeIn">
                    
                <form  method="post" id="frmObs">   
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox ">
                                        <div class="ibox-title">                                            
                                            <div class="form-group row">
                                                <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                                    <a  class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                                    <a  class="btn btn-sm btn-success btn-submenu" href="trabajadores_asignados_contratista.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestion de Trabajadores</a>
                                                </div>
                                            </div> 
                                            <?php include('resumen.php') ?>
                                        </div>
                                
                                
                                <div class="ibox-content">

                                                <table class="table table-responsive">
                                                    
                                                    <tr>
                                                     <?php 
                                                            #si esta acredetodo mostrar foto asociada al contrato
                                                            if ($existe_acreditado!=0) { ?>
                                                                <td class="fondo_td" rowspan="8">
                                                                    <div style="width:100%">
                                                                        <img width="100%"  src="<?php echo $result_ta['url_foto'] ?>" />
                                                                    </div>
                                                                </td>  
                                                              
                                                            <?php 
                                                        # sino esta acreditado
                                                              } else {
                                                                # sino tiene foto en la contratista agregar al contrato y contratista
                                                                if (empty($result_trabajador['url_foto'])) { ?>                                                                    
                                                                        <td class="fondo_td" rowspan="8">
                                                                            <div style="width:100%">
                                                                                <img id="foto_agregada_nueva" width="100%" heigth="150" src="img/sinimagen.png" />
                                                                            </div>
                                                                            <div style="background: #1C84C6;color:#fff;width:100%;padding:2%;margin-top:1%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span style="background:#1C84C6;color:#fff;width:100%" class="btn btn-default btn-file">
                                                                                    <span class="fileinput-new ">Agregar Foto</span>
                                                                                    <span id="btn-agregar" class="fileinput-exists">&nbsp;&nbsp;&nbsp;Cambiar Foto&nbsp;&nbsp;&nbsp;</span>
                                                                                    <input onchange="agregar_foto_contrato(<?php echo $id ?>,<?php echo $contrato ?>,<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $idcargo ?>,<?php echo $perfil ?>,'<?php echo $rut ?>')"  type="file" id="foto" name="foto" accept="image/jpeg,image/jpg" /></span>
                                                                            </div>
                                                                        </td>
                                                                
                                                                <?php
                                                                # si tiene una foto en la contratista
                                                                } else { 
                                                                        # sino tiene foto asignada al contrato, agrgar 
                                                                        if ($result_trabajador['foto_asignada']=="") { ?> 
                                                                        
                                                                            <td class="fondo_td" rowspan="8">                                                                                                                                                                                                                                            
                                                                                    <div style="width:100%">
                                                                                        <img id="foto_agregada" width="100%" heigth="150" src="<?php echo $result_trabajador['url_foto'] ?>" />
                                                                                    </div>
                                                                                    <div style="background: #1C84C6;color:#fff;width:100%;padding:2%;margin-top:2%;">
                                                                                        <button id="btn-agregar" type="button" style="border:1px #fff solid" class="btn btn-success btn-md btn-block"  onclick="agregar_foto_al_contrato(<?php echo $id ?>,<?php echo $contrato ?>,<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $idcargo ?>,<?php echo $perfil ?>,'<?php echo $rut ?>')">Agregar al Contrato</button>
                                                                                    </div>
                                                                            </td>
                                                                        
                                                                        <?php 
                                                                        # si ya tienen asignada al contrato
                                                                        } else { ?>
                                                                            <td class="fondo_td" rowspan="8">
                                                                                <div style="width:100%">
                                                                                        <img id="foto_cambiada" width="100%" src="<?php echo $result_trabajador['foto_asignada'] ?>" />
                                                                                </div>
                                                                                <div style="background: #1C84C6;color:#fff;width:100%;padding:2%;margin-top:1%;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span style="background: #1C84C6;color:#fff;width:100%;" class="btn btn-default btn-file">
                                                                                    <span class="fileinput-new">Cambiar Foto</span>
                                                                                    <span id="btn-agregar" class="fileinput-exists">Cambiar Foto</span>
                                                                                    <input onchange="cambiar_foto('<?php echo $rut ?>',<?php echo $contrato ?>,<?php echo $id ?>,<?php echo $perfil ?>)"  type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png" />
                                                                                    
                                                                                </div>
                                                                            </td>
                                                                        <?php 
                                                                        } ?> 
                                                        <?php   } 
                                                        
                                                            } ?>
                                                        
                                                    </tr> 

                                                    <tr>
                                                        <td class="fondo"><label class="col-form-label"><b>Contrato </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_contrato['nombre_contrato'] ?></label></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> Trabajador </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_trabajador['nombre1'].' '.$result_trabajador['nombre2'].' '.$result_trabajador['apellido1'].' '.$result_trabajador['apellido2']  ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> RUT </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_trabajador['rut'] ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> Cargo </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_cargo['cargo'] ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> Documentos </b></label></td>
                                                        <?php 
                                                            if (isset($result_trabajador['rut'])) { $rut_t=$result_trabajador['rut'];}  
                                                            $url ='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut_t.'/'.isset($result_ta['codigo']).'/zip/documentos_validados_trabajador_'.$rut_t.'.zip';
                                                            if ($existe_acreditado!=0) {  
                                                                
                                                                # sin foto en el contrato acreditado
                                                                    if ($result_ta['url_foto']=="") { ?>
                                                                    <td ><label class="col-form-label text-danger"><b>Trabajador Sin Foto</b></label></td>              
                                                            <?php 
                                                                # si hay foto en el contrato
                                                                  } else { ?>        
                                                                    <td ><label  class="col-form-label"><a class="" href="<?php echo $url ?>" ><u><b>Descargar</b></u></a></label></td>
                                                            <?php } ?>    
                                                            <?php } else { ?>
                                                                <td ><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td>
                                                            <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Vencimiento </b></label></td>
                                                        <?php 
                                                            if ($existe_acreditado!=0) {
                                                        ?>
                                                                <td ><label  class="col-form-label"><label class="col-form-label"><?php echo $result_ta['validez'] ;?> </label></td>
                                                            <?php } else { ?>
                                                                <td ><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td>
                                                            <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> Credencial </b></label></td>
                                                        <?php 
                                                            if ($existe_acreditado!=0) { 
                                                                # sin foto en el contrato acreditado
                                                                    if ($result_ta['url_foto']=="") { ?>
                                                                    <td ><label class="col-form-label text-danger"><b>Trabajador Sin Foto</b></label></td>            
                                                            <?php 
                                                                # si hay foto en el contrato
                                                                  } else { ?>        
                                                                    <td ><label class="col-form-label"><a style="margin-left: 2%;text-decoration:underline" class="" href="credencial.php?codigo=<?php echo $result_ta['codigo'] ?>" target="_blank"><b>Descargar</b></a></label></td>
                                                            <?php } ?>                
                                                        <?php } else { ?>
                                                                 <td ><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td> 
                                                                
                                                        <?php } ?>                                                        
                                                    </tr>

                                                </table>

                                
                                    <?php if($existe_acreditado==0) { ?>
                                        
                                        <div style="margin-top:3%" class="row">                            
                                                <!--<input type="hidden" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                                
                                                <table class="table table-stripped table-responsive" data-page-size="15" data-filter="#filter">
                                                
                                                <thead class="cabecera_tabla"s>
                                                    <tr>
                                                        <th style="width: 3%;" ></th>
                                                        <th style="width: 3%;border-right:1px #fff solid" ></th>
                                                        <th style="width: 25%;border-right:1px #fff solid">Documento</th>
                                                        <th style="width: 25%;border-right:1px #fff solid">Observaciones</th> 
                                                        <th style="width: 15%;text-align: center;border-right:1px #fff solid">Adjuntar</th>
                                                        <th style="width: 5%;text-align: center;border-right:1px #fff solid;">N/A</th>
                                                        <th style="width: 15%;border-right:1px #fff solid">Estado</th>
                                                        
                                                    </tr>
                                                    </thead>
                                                    
                                                <tbody>
                                                    
                                                <?php $i=0; 
                                                        $cont_veri=0;
                                                        $cont_doc=0;
                                                        $comentario=array();
                                                        $cadena=array();
                                                        $prexiste=false;
                                                        foreach ($doc as $row) {
                                                            $cont_doc=$cont_doc+1; 
                                                            $sql=mysqli_query($con,"select * from doc where id_doc='$row' ");  
                                                            $result=mysqli_fetch_array($sql);  
                                                            
                                                            $query_com=mysqli_query($con,"select * from comentarios where id_obs='".$id_obs."' and doc='".$result['documento']."' and estado='0' order by id_com desc ");
                                                            $result_com=mysqli_fetch_array($query_com);                                                            
                                                            $list_com=$result_com['comentarios'];

                                                            $query_com_existe=mysqli_query($con,"select * from comentarios where id_obs='".$id_obs."' and doc='".$result['documento']."'  order by id_com desc ");
                                                            $existe_com=mysqli_num_rows($query_com_existe);

                                                            $query_noaplica=mysqli_query($con,"select * from noaplica_trabajador where documento='$row' and contrato='$contrato' and trabajador='$id' ");
                                                            $resul_noaplica=mysqli_fetch_array($query_noaplica);
                                                                                                                 
                                                            
                                                            $carpeta_c='doc/trabajadores/'.$contratista.'/'.$result_trabajador['rut'].'/'.$result['documento'].'_'.$result_trabajador['rut'].'.pdf';
                                                            
                                                        if ($existe_acreditado¡=0) {                                           
                                                                $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut.'/'.$result_ta['codigo'].'/'.$result['documento'].'_'.$rut.'.pdf';
                                                            } else { 
                                                                $carpeta='doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut.'/'.$result['documento'].'_'.$rut.'.pdf';
                                                            } 
                                                            
                                                            
                                                            $archivo_existe=file_exists($carpeta); 
                                                            
                                                            $archivo_existe_c=file_exists($carpeta_c);
                                                            if (isset($result['id_cdoc'])) { $cadena[$i]=$result['id_cdoc']; }
                                                            
                                                            if (isset($result_com['id_dcom'])) {$comentario[$i]=$result_com['id_dcom'];} 
                                                            
                                                            ?>
                                                            
                                                            <tr>
                                                            <?php
                                                            
                                                                
                                                                    if ($archivo_existe_c) { ?>
                                                                            <!-- cargado -->
                                                                            <td style="text-align:center">                                                                                    
                                                                                    <input style="margin-left: 10%;" class="estilo2" type="checkbox" name="doc_existe[]" id="doc_existe<?php echo $i ?>" value="0" onclick="seldoc(<?php echo $i ?>)"  />
                                                                            </td>
                                                                            <td style="text-align:center;border-right:1px solid #BFC6D4 ">
                                                                                    <a href="<?php echo $carpeta_c ?>" target="_blank" ><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></a>
                                                                            </td>
                                                                    <?php } else { ?>       
                                                                            <td style="text-align:center">                                                                                    
                                                                                    <input disabled style="margin-left: 10%;" class="estilo2" type="checkbox" name="doc_existe[]" id="doc_existe<?php echo $i ?>" value="0" onclick="seldoc(<?php echo $i ?>)"  />
                                                                            </td> 
                                                                            <!-- cargado -->
                                                                            <td style="text-align:center;border-right:1px solid #BFC6D4">                                                                                
                                                                            <i style="color: #969696;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i>
                                                                            </td> 
                                                                                
                                                                    <?php }                                                  
                                                            
                                                                # si archivo existe 
                                                                if ($archivo_existe) { ?>
                                                                    <!-- documento  -->
                                                                    <td id="td_documento<?php echo $i ?>" style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                                    <?php                                                                 
                                                                    # sino esta verificado  
                                                                    if ($list_veri[$i]==0) {  ?>
                                                                            <!--  observaciones  -->     
                                                                            <td>
                                                                                <div class="btn-group"> 
                                                                                    <?php if ($existe_com>0) { ?>
                                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                                        <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo  $row ?>,<?php echo $id ?>,<?php echo $contrato ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                    <?php } else { ?>
                                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                                        <button class="btn btn-sm btn-success" type="button" disabled ><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </td>
                                                                
                                                                    <!-- estado  --->     
                                                                        <?php 
                                                                        if (isset($result_com['doc'])==isset($result['documento'])) {
                                                                            if ($result_com['leer_mandante']==1 and $result_com['leer_contratista']==1) { 
                                                                                # reenviado
                                                                                $estado='2'; ?>     
                                                                                <input type="hidden" id="estado_doc<?php echo $i ?>" value="2">                                                                                   
                                                                                    
                                                                                <?php 
                                                                                if ($resul_noaplica['documento']==$row) { ?> 

                                                                                     <!-- adjuntar  obs atendida -->
                                                                                     <td  style="text-align:center">
                                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span id="span_seleccionar<?php echo $i ?>"  style="background: #282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf" onclick="seleccionar(t<?php echo $i ?>)"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td> 

                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>" checked /></td>

                                                                                <?php 
                                                                                } else { ?>

                                                                                     <!-- adjuntar  obs atendida -->
                                                                                     <td  style="text-align:center">
                                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span id="span_seleccionar<?php echo $i ?>"  style="background: #282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td> 

                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>"  /></td>
                                                                                <?php 
                                                                                }  ?>
                                                                                <td style="text-align:center;font-size:14px;font-weight:700"><div id="estado<?php echo $i ?>" class="bg-info p-xxs text-mute">EN PROCESO</div></td>
                                                                            <?php  
                                                                            }      
                                                                            if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) {                                                                                     
                                                                                # observacion
                                                                                $estado='3'; ?>
                                                                                <input type="hidden" id="estado_doc<?php echo $i ?>" value="3">                                                                                    
                                                                                <?php 
                                                                                if (isset($resul_noaplica['documento'])==isset($row)) { ?>

                                                                                    <td id="div_seleccionar<?php echo $i ?>"  style="text-align:center;display:none">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span id="span_seleccionar<?php echo $i ?>"  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>
                                                                                
                                                                                    <td id="div_seleccionar2<?php echo $i ?>"  style="text-align:center;">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span  style="background:#282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  onclick="seleccionar(<?php echo $i ?>)" /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>
                                                                                    
                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>" checked /></td>
                                                                                <?php 
                                                                                } else { ?>

                                                                                    <td  style="text-align:center">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>"  /></td>
                                                                                <?php 
                                                                                }  ?>
                                                                                <td style="text-align:center;font-size:14px;font-weight:700"><div id="estado<?php echo $i ?>" class="bg-info p-xxs text-mute">OBSERVACION</div></td>
                                                                            <?php 
                                                                            }
                                                                        } else { 
                                                                                # enviado
                                                                                $estado='4'; ?>
                                                                                <input type="hidden" id="estado_doc<?php echo $i ?>" value="4">                                                                                  
                                                                                   
                                                                                <?php 
                                                                                if (isset($resul_noaplica['documento'])==isset($row)) { ?>

                                                                                    <td id="div_seleccionar<?php echo $i ?>"  style="text-align:center;display:none">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span id="span_seleccionar<?php echo $i ?>"  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>
                                                                                
                                                                                    <td id="div_seleccionar2<?php echo $i ?>"  style="text-align:center;">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span  style="background:#282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  onclick="seleccionar(<?php echo $i ?>)" /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>
                                                                                    
                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>" checked /></td>
                                                                                <?php 
                                                                                } else { ?>

                                                                                    <td  style="text-align:center">
                                                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                            <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"> Seleccionar archivo</span>
                                                                                            <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"   /></span>
                                                                                            <span class="fileinput-filename"></span>                                                             
                                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>"  /></td>
                                                                                <?php 
                                                                                }  ?>

                                                                                <td style="text-align:center;font-size:14px;font-weight:700"><div id="estado<?php echo $i ?>" class="bg-info p-xxs text-mute">EN PROCESO</div></td>
                                                                        <?php 
                                                                        }      
                                                                                                                                
                                                                    # si esta verificado
                                                                    } else { 
                                                                        # verificado
                                                                        $estado='5';    
                                                                        $cont_veri=$cont_veri+1; ?>
                                                                        <input type="hidden" id="estado_doc<?php echo $i ?>" value="5">

                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                                    <?php if ($existe_com>0) { ?>
                                                                                        <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo  $row ?>,<?php echo $id ?>,<?php echo $contrato ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                    <?php } else { ?>
                                                                                        <button class="btn btn-sm btn-success" type="button" disabled ><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                    <?php } ?>
                                                                            </div>
                                                                        </td>
                                                                        
                                                                        <!-- adjuntar  -->
                                                                        <td  style="text-align:center">

                                                                                <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Validado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                        <input type="text"   />                   
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div> 
                                                                                
                                                                                <div style="display: none"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Validado</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                    <input type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"  />                                                                   
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td>
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" disabled  /></td>
                                                                        <!-- estado  --->  
                                                                        <td style="text-align:center"><div style="font-size: 14px;" class="bg-success p-xxs"><b>VALIDADO</b></div></td>
                                                                 <?php }
                                                            
                                                            # si archivo no existe  
                                                            } else {
                                                                # no enviado
                                                                $estado='1';  ?>
                                                                <input type="hidden" id="estado_doc<?php echo $i ?>" value="1">    
                                                                                                                        
                                                                <!-- documento -->
                                                                <td  id="td_documento<?php echo $i ?>"><?php echo $result['documento'] ?></td>

                                                                <!-- observaciones -->
                                                                <td>
                                                                        <div class="btn-group"> 
                                                                            <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                            <button class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                        </div>
                                                                </td>
                                                                    
                                                                                                                                            
                                                                        <td id="div_seleccionar<?php echo $i ?>"  style="text-align:center;">
                                                                            <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                <span id="span_seleccionar<?php echo $i ?>" style="background: #282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span class="fileinput-new">Seleccionar archivo</span>
                                                                                <span class="fileinput-exists">Cambiar</span><input class="archivo"  type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" accept="application/pdf" onclick="seleccionar()"  /></span>
                                                                                <span class="fileinput-filename"></span>                                                             
                                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </td>
                                                                        <!-- adjuntar 
                                                                        <td id="div_seleccionar2"  style="text-align:center;display:none">
                                                                            <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                <span id="span_seleccionar" style="background: #282828;color: #000;border:#282828;color:#fff;width:100%" class="btn btn-default btn-file"><span class="fileinput-new">Seleccionar atchivo</span>
                                                                                <span class="fileinput-exists">Cambiar</span><input  id="carga_doc_t"onclick="prueba()" type="button"  /></span>
                                                                                <span class="fileinput-filename"></span>                                                             
                                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </td>--> 
                                                                
                                                                <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,<?php echo $contrato ?>,<?php echo $id ?>,'<?php echo $rut ?>' )" value="<?php echo $row  ?>"  /></td>
                                                                
                                                                <!-- esTado -->                                                                  
                                                                <td style="text-align:center"><div id="estado<?php echo $i ?>" style="font-size: 14px;" class="bg-danger p-xxs"><b>NO ENVIADO</b></div></td>
                                                                  
                                                                    
                                                            </tr> 
                                                                
                                                            <?php } ?> 
                                                            
                                                    <?php                                      
                                                    echo '<input type="hidden" name="cadena_doc[]" id="cadena_doc'.$i.'" value="'.$result['id_doc'].'" />';
                                                    echo '<input type="hidden" name="comentario[]" id="comentario'.$i.'" value="'.isset($result_com['id_com']).'" />';
                                                    $i++;} 

                                                            $query_com=mysqli_query($con,"select * from comentarios where id_obs='".$id_obs."' and doc='Foto del trabajador' and trabajador='$id' and estado='0' order by id_com desc ");
                                                            $result_com=mysqli_fetch_array($query_com);

                                                            $query_com_existe_foto=mysqli_query($con,"select * from comentarios where id_obs='".$id_obs."' and doc='Foto del trabajador' and trabajador='$id' order by id_com desc ");
                                                            $existe_com_foto=mysqli_num_rows($query_com_existe_foto);

                                                            if (isset($result_com['comentarios'])) {$list_com_foto=$result_com['comentarios'];}  

                                                            if ($result_trabajador['foto_asignada']=="") { ?> 
                                                            <input type="hidden" id="num_foto" value="<?php echo $i ?>" > 
                                                                     <tr>
                                                                        <!-- documento -->
                                                                        <td></td>
                                                                        <td style="text-align:center;border-right:1px solid #BFC6D4 "></td>
                                                                        <td  style="">Foto del trabajador</td>                                                                        
                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            </div>
                                                                        </td>
                                                                        
                                                                        <!-- adjuntar  -->
                                                                        <td  style="text-align:center">

                                                                                <div style="background: #969696;color: #000;border:#969696;color:#fff;width:100%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"></span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                        <input type="text"   />                   
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div> 
                                                                                
                                                                                <div style="display: none"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Validado</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                        <input type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"  />                                                                   

                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td>
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" disabled  /></td>
                                                                        <!-- estado  --->  
                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div id="estado<?php echo $i ?>" class="bg-danger p-xxs">NO ENVIADO</div></td>
                                                                    </tr>
                                                            <?php 
                                                            } else { ?>
                                                                    <tr>
                                                                        <!-- documento -->
                                                                        <td></td>
                                                                        <td style="text-align:center;border-right:1px solid #BFC6D4 "></td>
                                                                        <td  style="">Foto del trabajador</td>                                                                        
                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                            <?php if ($existe_com_foto>0) { ?>
                                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com_foto ?></textarea>
                                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(35,<?php echo $id ?>,<?php echo $contrato ?>,<?php echo $contrato ?>)" ><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            <?php } else { ?>
                                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            <?php }  ?>
                                                                                
                                                                            </div>
                                                                        </td>
                                                                        
                                                                        <!-- adjuntar  -->
                                                                        <td  style="text-align:center">
                                                                                <div style="background: #969696;color: #000;border:#969696;color:#fff;width:100%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"></span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                        <input type="text"   />                   
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div> 
                                                                                
                                                                                <div style="display: none"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span id="texto<?php echo $i ?>" class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Validado</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                                        <input type="file" id="carga_doc_t<?php echo $i ?>" name="carga_doc_t[]" multiple="" accept="application/pdf"  />                                                                   

                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td>
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" disabled  /></td>
                                                                        <!-- estado  --->  
                                                                         <?php if ($list_veri[$i]==0) {  
                                                                                if (empty($list_com_foto)) {  ?>
                                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">EN PROCESO</div></td>
                                                                                    <?php 
                                                                                } else { ?>
                                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">OBSERVACION</div></td>
                                                                                <?php 
                                                                                } ?>
                                                                           
                                                                        <?php } else {  ?>
                                                                            <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-success p-xxs text-mute">VALIDADO</div></td>
                                                                        <?php }   ?>
                                                                    </tr>

                                                            <?php 
                                                            }  ?> 
                                                            <tr >                                                               
                                                                <td colspan="7" >
                                                                
                                                                </td>
                                                            </tr>
                                                    
                                                            <tr style="border:1px #c0c0c0 solid;border-radius:5px; padding: 0.5% 0%">                                                               
                                                                <td colspan="7" >
                                                                        <button style="font-size:16px" title="Procesar Documentos" class="btn-success btn btn-md col-5" type="button" onclick="cargar_doc_trabajador(<?php echo $i ?>,'<?php echo $result_trabajador['rut'] ?>','<?php echo $result_contrato['nombre_contrato'] ?>')" >ENVIAR DOCUMENTOS <?php  ?></button>
                                                                </td>
                                                            </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div> 
                                    <?php 
                                
                                    # trabajadpr acreditado                                    
                                    } else { ?>

                                        <div style="margin-top:3%" class="row">  
                                            <div class="table table-responsive">
                                                <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                                    <thead>
                                                        <tr style="background: #010829;color:#fff">
                                                            <th style="width: 3%;" >#</th>
                                                            <th style="width: 97%;">Documentos Acreditados del Trabajador</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                                $i=1;
                                                                foreach ($doc_ta as $row) {
                                                                        
                                                                        
                                                                    $sql=mysqli_query($con,"select * from doc where id_doc='$row' ");  
                                                                    $result=mysqli_fetch_array($sql);  
                                                                        
                                                                    $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$result['documento'].'_'.$rut.'.pdf';
                                                                ?>        
                                                                <tr>
                                                                    <td><?php echo $i ?></td>
                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>

                                                                </tr> 
                                                                <?php $i++;} ?>

                                                                <!-- dcumentos mensuale -->
                                                                <?php    
                                                                    $query_dm=mysqli_query($con,"select d.documento, m.* from mensuales_trabajador as m Left Join doc_mensuales as d On d.id_dm=m.doc where m.verificado=1 and m.trabajador='$id' ");
                                                                    $d=$i;    
                                                                    foreach ($query_dm as $row) {
                                                                        $carpeta_d= 'doc/validados/'.$row['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'_'.$row['mes'].'_'.$row['year'].'.pdf';; 
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $d ?></td>
                                                                    <td style=""><a href="<?php echo $carpeta_d ?>" target="_blank"><?php echo $row['documento'].' ('.$row['mes'].'-'.$row['year'].')' ?></a></td>        
                                                                </tr>
                                                                <?php
                                                                   $d++; }  
                                                                ?>

                                                                <!-- documentos extras tipo 2 --->    
                                                                <?php
                                                                    $query_de2=mysqli_query($con,"select d.* from documentos_extras as d where d.contrato='".$contrato."' and trabajador='".$_SESSION['trabajador']."' and d.tipo=2 and d.estado=3 ");
                                                                    $result_de=mysqli_fetch_array($query_de2);
                                                                    $cantidad2=mysqli_num_rows($query_de2);
        
                                                                    $j=$d;    
                                                                    # si hay documentos extras tipo 2                                               
                                                                 
                                                                        $existe=0;
                                                                        foreach ($query_de2 as $row) { 
                                                                            $carpeta = 'doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'.pdf'; 
                                                                              
                                                                ?>
                                                                            <tr>    
                                                                                <td><?php echo $j ?></td>
                                                                                <!-- documento  -->
                                                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                                                            </tr>
                                                                        <?php  
                                                                        $j++;}
                                                                        ?>  

                                                            <!-- documentos extras tipo 3 --->    
                                                            <?php
                                                                    $query_de2=mysqli_query($con,"select d.* from documentos_extras as d where d.contrato='".$contrato."' and trabajador='".$_SESSION['trabajador']."' and d.tipo=3 and d.estado=3 ");
                                                                    $result_de=mysqli_fetch_array($query_de2);
                                                                    $cantidad2=mysqli_num_rows($query_de2);
        
                                                                    $e=$j;    
                                                                    # si hay documentos extras tipo 2                                               
                                                                 
                                                                        $existe=0;
                                                                        foreach ($query_de2 as $row) { 
                                                                            $carpeta = 'doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'.pdf'; 
                                                                              
                                                                ?>
                                                                            <tr>    
                                                                                <td><?php echo $e ?></td>
                                                                                <!-- documento  -->
                                                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                                                            </tr>
                                                                        <?php  
                                                                        $e++;}
                                                                        ?>           
                                                            
                                                            </tbody>
                                                        </table>
                                                       <hr> 
                                                </div>
                                        </div>

                                    <?php } ?>    

                                <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" />
                                <input type="hidden" name="trabajador" id="trabajador" value="<?php echo $_SESSION['trabajador'] ?>" /> 
                                <div class="form-group row">
                                    <div class="col-12">
                                    
                                        <?php if ($cont_veri==$cont_doc) { ?>
                                        <!-- <a class="btn btn-sm btn-primary" type="button" href="certificado.php?id=<?php echo $id ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Descargar Certificado</a>-->
                                        <?php } ?>  
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        </form>  
                    </div>
                                <script>
                                    
                                    function adjuntar(id,doc,com,contratista,mandante,contrato) {
                                            $('.body').load('selid_ver_archivos_contratistas.php?trabajador='+id+'&doc='+doc+'&com='+com+'&contratista='+contratista+'&mandante='+mandante+'&contrato='+contrato,function(){
                                                        $('#modal_archivos').modal({show:true});
                                                });
                                    }
                                    
                                        function modal_ver_obs(id_doc,id,contrato) {
                                            //alert(id_doc+' '+id+' '+contrato);
                                            var condicion=0;
                                            $('.body').load('selid_ver_obs.php?doc='+id_doc+'&id='+id+'&contrato='+contrato,function(){
                                                        $('#modal_ver_obs').modal({show:true});
                                                });
                                        } 

                                    function modal_no_aplica(id_doc,num,doc,contratista,mandante,contrato,id,rut) {       
                                    //document.getElementById("estado_na"+num).style.backgroundColor="#969696";
                                    //document.getElementById("estado_na"+num).innerHTML="<small>N/A<small>";                                                                   
                                    if ($('#aplica'+num).is(':checked')) {                                        
                                        document.getElementById("doc_text").innerText=doc;
                                        $('#modal_no_aplica #doc_na').val(id_doc);   
                                        $('#modal_no_aplica #num_na').val(num); 
                                        $('#modal_no_aplica #contratista_na').val(contratista)
                                        $('#modal_no_aplica #contrato_na').val(contrato)
                                        $('#modal_no_aplica #mandante_na').val(mandante)
                                        $('#modal_no_aplica #trabajador_na').val(id)
                                        $('#modal_no_aplica #documento_na').val(doc)
                                        $('#modal_no_aplica #rut_na').val(rut)
                                        $('#modal_no_aplica').modal({show:true});
                                    } else {

                                        swal({
                                            title: "Retirar Documento No Aplica "+doc,
                                            //text: "You will not be able to recover this imaginary file!",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "Si, retirar",
                                            closeOnConfirm: false
                                        }, function () {
                                            $.ajax({
                                                        method: "POST",
                                                        url: "add/addquitarnoaplica_trabajador.php",
                                                        data:'contratista='+contratista+'&doc='+id_doc+'&mandante='+mandante+'&rut='+rut+'&contrato='+contrato+'&trabajador='+id, 
                                                        success: function(data){
                                                            if (data==0) {                                                                                                                                                        
                                                                // poner boto seleccionar en negro
                                                                document.getElementById('span_seleccionar'+num).style.backgroundColor='#282828';
                                                                
                                                                // quitar enlace en nombre de documento
                                                                $('#td_documento'+num).removeAttr('href');                                                                
                                                                
                                                                // cambiar estado a EN PROCESO                                                  
                                                                $('#estado'+num).removeAttr('class');
                                                                $('#estado'+num).attr('class','bg-danger p-xxs');                                                                
                                                                document.getElementById('estado'+num).innerHTML='<b style="font-13px">NO ENVIADO</b>';
                                                                
                                                                // quitar mensaje 
                                                                document.getElementById('mensaje'+num).innerHTML='';

                                                                $("#aplica"+num).prop("checked", false);
                                                                
                                                                document.getElementById('div_seleccionar'+num).style.display='none';
                                                                document.getElementById('div_seleccionar2'+num).style.display='block';
                                                                document.getElementById('span_seleccionar'+num).style.backgroundColor='#b3992e';
                                                                
                                                                swal({
                                                                    title: "Documento Trabajador No Aplica Retirado",
                                                                    //text: "Un Documento no validado esta sin comentario",
                                                                    type: "success"
                                                                })                                                        
                                                                
                                                            } else {
                                                                swal({
                                                                    title:"Disculpe, Error de Sistema",
                                                                    text: "Vuelva a intentar",
                                                                    type: "warning"
                                                                })
                                                            }
                                                        }   
                                                    });
                                        });
                                        $("#aplica"+num).prop("checked", true);
                                                                           
                                   }
                                }
                                
                                        
                                
                                </script>

                            <div class="modal inmodal" id="modal_no_aplica" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content animated fadeIn">
                                            <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                                <h3 style="font-weight:bold;" id="titulo" class="modal-title">Docs. No Aplica Trabajador</h4>
                                            </div>                                   
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label>Documento:</label>
                                                        </div>            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <h3 id="doc_text" class="form-label"></h3>                                                        
                                                        </div>            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <textarea rows="3" class="form-control" id="mensaje_na" name="mensaje_na" placeholder="escriba un mensaje" ></textarea>
                                                        </div>            
                                                    </div>
                                            </div>
                                            <input type="hidden" id="num_na" name="num_na" >
                                            <input type="hidden" id="contratista_na" name="contratista_na" >
                                            <input type="hidden" id="contrato_na" name="contrato_na" >
                                            <input type="hidden" id="mandante_na" name="mandante_na" >
                                            <input type="hidden" id="doc_na" name="doc_na" >
                                            <input type="hidden" id="documento_na" name="documento_na" >
                                            <input type="hidden" id="trabajador_na" name="trabajador_na" >
                                            <input type="hidden" id="rut_na" name="rut_na" >
                                            
                                            <div class="modal-footer">        
                                                        <button  class="btn btn-secondary btn-sm"  onclick="cerrar_no_aplica()" >Cancelar</button>    
                                                        <button  class="btn btn-success btn-sm" onclick="guardar_no_aplica(<?php echo $mandante ?>)" >Enviar Documento</button>
                                            </div>                            
                                   </div>
                                </div>
                            </div>   
                    
                                <div class="modal  fade" id="modal_archivos" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div  class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Adjuntar Documento</h3>
                                                <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="body">
                                                </div> 
                                                <div class="modal-footer">
                                                <button style="color: #fff;" class="btn btn-danger" value="" onclick="window.location.href='verificar_documentos_contratista.php'" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <div class="modal inmodal" id="modal_ver_obs" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                             <div class="modal-content animated fadeIn">
                                                <div style="background:#e9eafb;color:#282828" class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                                    <h4 class="modal-title">Historial de Observaciones</h4>
                                                </div>
                                                <div class="body">                                             
                                                </div>                                    
                                        </div>
                                        </div>
                                </div>  
                               
                                <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="loader"></div>
                                            <h3>Por favor espere un momento..</h3>
                                        </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
                                                    </div>
                                                </div>     
                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                    
                    
                    
                                <?php echo include('footer.php') ?>

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
            
            <!-- Jasny -->
            <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

            <!-- DROPZONE -->
            <script src="js\plugins\dropzone\dropzone.js"></script>

            <!-- CodeMirror -->
            <script src="js\plugins\codemirror\codemirror.js"></script>
            <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
            

            <!-- iCheck -->
            <script src="js\plugins\iCheck\icheck.min.js"></script>
            
            <!-- Sweet alert -->
            <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
            
            <!-- Ladda -->
            <script src="js\plugins\ladda\spin.min.js"></script>
            <script src="js\plugins\ladda\ladda.min.js"></script>
            <script src="js\plugins\ladda\ladda.jquery.min.js"></script>

        <script>

            $(document).ready(function() {

                $("#modal_no_aplica").on('hidden.bs.modal', function () {        
                    var num=$("#num_na").val();        
                    $("#aplica"+num).prop("checked", false);
                    //window.location.href='gestion_documentos.php';
                });

                    $('.footable').footable();
                    $('.footable2').footable();
                                
                    
                    
            });
                                                

        </script>


        </div>

        </body>

        </html>
<?php #} else {
       # echo "<script> window.location.href='list_contratos_contratistas.php'; </script>";
      #}

    } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
