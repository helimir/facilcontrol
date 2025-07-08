<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

require 'PayPal-PHP-SDK/autoload.php';

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment; // Usa ProductionEnvironment para producción
use PayPalCheckoutSdk\Subscriptions\SubscriptionsCreateRequest;

$clientId = 'AUBukDP64DaNU_8VliKUi1FYqmQLlkMBgThZDf-cXdtDiHGKaOIfZJZPs56-ViLHhHYVUqU9Z-x4gx-J';
$clientSecret = 'EA8v6dHQXIYTQySPI1gz7Of36Qn9H5uTFg1Xb71eS1EVq6VSTzsHTrh9FOG06LIrxuwkaq1-ZiEfK7U5';

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

//$planId = $_POST['plan'] === 'monthly' ? 'P-123456789' : 'P-987654321'; // Reemplaza con tus IDs de plan reales
$planId = $_POST['plan']; // Reemplaza con tus IDs de plan reales

$request = new SubscriptionsCreateRequest();
$request->body = [
    "plan_id" => $planId,
    "start_time" => date('c', strtotime('+1 minute')),
    "subscriber" => [
        "name" => [
            "given_name" => "Juan",
            "surname" => "Pérez"
        ],
        "email_address" => "juan.perez@example.com"
    ],
    "application_context" => [
        "brand_name" => "Mi Empresa",
        "locale" => "es-ES",
        "shipping_preference" => "NO_SHIPPING",
        "user_action" => "SUBSCRIBE_NOW",
        "payment_method" => [
            "payer_selected" => "PAYPAL",
            "payee_preferred" => "IMMEDIATE_PAYMENT_REQUIRED"
        ],
        "return_url" => "https://facilcontrol.cl/pagos/success.php",
        "cancel_url" => "https://facilcontrol.cl/pagos/cancel.php"
    ]
];

try {
    $response = $client->execute($request);
    header('Location: ' . $response->result->links[0]->href);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>