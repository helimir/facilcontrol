<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción</title>
</head>
<body>
    <h1>Elige tu Plan de Suscripción</h1>
    <form action="create_subscription.php" method="POST">
        <label>
            <input type="radio" name="plan" value="P-4MY498924G8976841M6XKRNA" required> 
            Mensual - $10/mes
        </label>
        <br>
        <label>
            <input type="radio" name="plan" value="P-93W80949GJ431710BM6XKSBI" required> 
            Anual - $100/año
        </label>
        <br><br>
        <button type="submit">Suscribirse</button>
    </form>
</body>
</html>