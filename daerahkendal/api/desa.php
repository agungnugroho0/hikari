<?php
require_once __DIR__ . '/../autoloader.php';
use app\controller\desacontroller;
header("Access-Control-Allow-Origin: *"); // biar bisa diakses lintas platform
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$controller = new desacontroller();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // READ
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $desa = $controller->getDesaById($id);
            if ($desa) {
                echo json_encode($desa);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Desa not found']);
            }
        } else {
            $desas = $controller->getAllDesa();
            echo json_encode($desas);
        }
        break;

    case 'POST': // CREATE
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($data['id_desa']) && !empty($data['nama_desa'])) {
            $controller->createDesa($data['id_desa'], $data['nama_desa']);
            echo json_encode(['message' => 'Desa created']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid data']);
        }
        break;

    case 'PUT': // UPDATE
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'ID required']);
            break;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $updated = $controller->updateDesa($_GET['id'], $data['nama_desa'] ?? '');
        if ($updated) {
            echo json_encode(['message' => 'Desa updated']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Desa not found']);
        }
        break;

    case 'DELETE': // DELETE
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'ID required']);
            break;
        }
        $deleted = $controller->deleteDesa($_GET['id']);
        if ($deleted) {
            echo json_encode(['message' => 'Desa deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Desa not found']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
}