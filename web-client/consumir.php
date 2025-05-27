<?php
$ciudad = $_POST['ciudad'];
$cliente = new SoapClient(null, array(
    'location' => 'http://localhost/BotAgroEco/soap-server/server.php',
    'uri' => 'http://localhost/BotAgroEco/soap-server/',
    'trace' => 1
));

$resultado = $cliente->__soapCall("obtenerClimaYConsejo", array($ciudad));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado ClimaAgro</title>
    <link rel="shortcut icon" href="https://cdn.ecologiaverde.com/img/web/ecologiaverde/favicon.ico">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 500px;
            margin: 80px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            font-size: 18px;
            color: #34495e;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background:rgb(41, 185, 72);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
        }
        a:hover {
            background:rgb(36, 163, 78);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado del Clima 🌤️</h1>
        <p><?php echo htmlspecialchars($resultado); ?></p>
        <a href="index.html">⟵ Volver</a>
    </div>
</body>
</html>
