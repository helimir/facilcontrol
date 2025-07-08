<?php
require 'vendor/PayPal-PHP-SDK/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment; // Usa ProductionEnvironment en producción
use PayPalCheckoutSdk\Subscriptions\SubscriptionsCreateRequest;

// Configura las credenciales de PayPal
$clientId = 'AUBukDP64DaNU_8VliKUi1FYqmQLlkMBgThZDf-cXdtDiHGKaOIfZJZPs56-ViLHhHYVUqU9Z-x4gx-J';
$clientSecret = 'AUBukDP64DaNU_8VliKUi1FYqmQLlkMBgThZDf-cXdtDiHGKaOIfZJZPs56-ViLHhHYVUqU9Z-x4gx-J';

// Configura el entorno (Sandbox para pruebas, Production para producción)
$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

// Obtén el plan seleccionado desde el formulario
$planId = 'P-93W80949GJ431710BM6XKSBI'; // PLAN_MENSUAL_ID o PLAN_ANUAL_ID

echo 'helimir';
// Crea la solicitud de suscripción
$request = new SubscriptionsCreateRequest();
$request->prefer('return=representation');
$request->body = [
    "plan_id" => $planId,
    "start_time" => date('c', strtotime('+1 minute')), // Inicia en 1 minuto
    "subscriber" => [
        "name" => [
            "given_name" => "Juan",
            "surname" => "Pérez"
        ],
        "email_address" => "juan.perez@example.com"
    ],
    "application_context" => [
        "brand_name" => "Tu Empresa",
        "locale" => "es-ES",
        "shipping_preference" => "NO_SHIPPING",
        "user_action" => "SUBSCRIBE_NOW",
        "return_url" => "https://facilcontrol.cl/suscripcion.php", // URL de éxito
        "cancel_url" => "https://facilcontrol.cl/suscripcion.php"  // URL de cancelación
    ]
];

try {
    // Ejecuta la solicitud
    $response = $client->execute($request);
    
    // Redirige al usuario a la URL de aprobación de PayPal
    foreach ($response->result->links as $link) {
        if ($link->rel === 'approve') {
            header('Location: ' . $link->href);
            exit;
        }
    }
} catch (Exception $e) {
    // Maneja errores
    echo "Error: " . $e->getMessage();
}
?>