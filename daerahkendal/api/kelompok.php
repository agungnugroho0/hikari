<?php
require_once __DIR__ . '/../autoloader.php';
use app\controller\kelompokcontroller;
header("Access-Control-Allow-Origin: *"); // biar bisa diakses lintas platform
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$controller = new kelompokcontroller();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET': // READ
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $desa = $controller->getKelompokById($id);
            if ($desa) {
                echo json_encode($desa);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Kelompok not found']);
            }
        } else {
            $kelompoks = $controller->getAllKelompok();
            echo json_encode($kelompoks);
        }
        break;

    case 'POST': // CREATE
        $data = json_decode(file_get_contents('php://input'), true);
        if (!empty($data['id_kelompok']) && !empty($data['nama_kelompok'])) {
            $controller->createKelompok($data['id_kelompok'], $data['nama_kelompok']);
            echo json_encode(['message' => 'kelompok created']);
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
        $updated = $controller->updateKelompok($_GET['id'], $data['nama_kelompok'] ?? '');
        if ($updated) {
            echo json_encode(['message' => 'Kelompok updated']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Kelompok not found']);
        }
        break;

    case 'DELETE': // DELETE
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'ID required']);
            break;
        }
        $deleted = $controller->deleteKelompok($_GET['id']);
        if ($deleted) {
            echo json_encode(['message' => 'Kelompok deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Kelompok not found']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
}