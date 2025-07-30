<?php
require_once '../utils/functions.php';

ob_start();
header('Content-Type: application/json');

$dataFile = '../data/servicios.json';
$method = $_SERVER['REQUEST_METHOD'];
$data = readData($dataFile);

switch ($method) {
    case 'GET':
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $data[] = $input;
        saveData($dataFile, $data);
        echo json_encode(["mensaje" => "Servicio creado"]);
        break;

    case 'PUT':
        $params = [];
        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $params);
        }
        $id = $params['id'] ?? null;

        if ($id !== null && isset($data[$id])) {
            $input = json_decode(file_get_contents('php://input'), true);
            $data[$id] = $input;
            saveData($dataFile, $data);
            echo json_encode(["mensaje" => "Servicio actualizado"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Servicio no encontrado"]);
        }
        break;

    case 'DELETE':
        $params = [];
        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $params);
        }
        $id = $params['id'] ?? null;

        if ($id !== null && isset($data[$id])) {
            array_splice($data, $id, 1);
            saveData($dataFile, $data);
            echo json_encode(["mensaje" => "Servicio eliminado"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Servicio no encontrado"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}

ob_end_flush();
?>
