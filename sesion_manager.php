<?php
// Configuraci�n de sesi�n
$tiempo_inactividad = 43200; // 10 minutos

// Establece el tiempo de expiraci�n para la cookie de sesi�n
ini_set('session.gc_maxlifetime', $tiempo_inactividad);
session_set_cookie_params($tiempo_inactividad);

session_start();

// Verifica si hay actividad previa
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $tiempo_inactividad) {
    // Tiempo de inactividad excedido
    session_unset();
    session_destroy();
    header("Location: admin.php");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Actualiza el tiempo de actividad

// Verifica si la sesi�n fue creada hace mucho tiempo
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 43200) { // 1 hora de vida total
    // Fuerza regeneraci�n de sesi�n por seguridad
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}

// Verifica que el usuario est� autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: admin.php");
    exit;
}
?>
