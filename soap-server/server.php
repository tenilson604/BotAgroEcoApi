<?php
ini_set("soap.wsdl_cache_enabled", "0");
require_once("../db/db.php");

function obtenerClimaYConsejo($ciudad) {
    global $conn;

    // API Key y URL
    $apiKey = "22da5f638d960e211d0d1939430fa498";
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$ciudad&appid=$apiKey&units=metric&lang=es";

    // Llamada a la API
    $response = file_get_contents($url);
    if (!$response) return "Error al consultar API.";

    $data = json_decode($response, true);

    // Validar datos
    if (!isset($data["main"]["temp"]) || !isset($data["weather"][0]["description"])) {
        return "Error: No se pudo obtener el clima o temperatura.";
    }

    $temp = floatval($data["main"]["temp"]);
    $clima = $data["weather"][0]["description"];

    // Lógica de recomendación
    if ($temp < 15) {
        $recomendacion = "No es recomendable sembrar. Hace frío.";
    } elseif ($temp >= 15 && $temp <= 25) {
        $recomendacion = "Buen clima para sembrar maíz o papa.";
    } else {
        $recomendacion = "Buen clima para sembrar arroz o caña de azúcar.";
    }

    // Guardar en la base de datos
    $stmt = $conn->prepare("INSERT INTO consultas (ciudad, clima, recomendacion) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ciudad, $clima, $recomendacion);
    $stmt->execute();

    // Resultado
    return "Clima: $clima, Temp: $temp °C, Recomendación: $recomendacion";
}

$server = new SoapServer(null, array('uri' => "http://localhost/BotAgroEco/soap-server/"));
$server->addFunction("obtenerClimaYConsejo");
$server->handle();
?>


