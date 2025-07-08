<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
 session_start();
session_destroy($_SESSION['titulo']);
switch ($_POST['nav']) {
    
    case "crear_contratista":$_SESSION['titulo']='Crear Contratista';break;
    case "list_contratistas":$_SESSION['titulo']='Listado Contratistas';break;
    case "crear_contrato":$_SESSION['titulo']='Crear Contratos';break;
    case "list_contratos":$_SESSION['titulo']='Listado Contratos';break;
    case "crear_perfil":$_SESSION['titulo']='Crear Perfiles';break;
    case "list_perfil":$_SESSION['titulo']='Listado Perfiles';break;
    case "gestion_contratos":$_SESSION['titulo']='Gestion de Contratos';break;
    case 'contratistas_acreditadas':$_SESSION['titulo']='Contratistas Acreditadas';break;
    
    case 'crear_trabajador':$_SESSION['titulo']='Crear Trabajador';break;
    case 'list_trabajadores':$_SESSION['titulo']='Listado Trabajadores';break;
    case 'perfil_contratista':$_SESSION['titulo']='Perfil Contratista';break;
    case 'trabajadores_acreditados':$_SESSION['titulo']='Trabajadores Acreditados';break;
    case 'gestion_documentos':$_SESSION['titulo']='Documentos Contratista';break;
    case 'gestion_documentos_mensuales':$_SESSION['titulo']='Documentos Mensuales';break;
    case 'notificaciones':$_SESSION['titulo']='Notificaciones';break;
    
    case 'facil_pro':$_SESSION['titulo']='FacilControl PRO';break;
}    	

?>