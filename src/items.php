<?php

require 'database/Database.php';

$db = new Database;

require 'controllers/Item.php';

// Router
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_parse = explode('/', trim($url, '/'));

if (!empty($url_parse[0]) && $url_parse[0] === 'items.php') {
    $id = isset($url_parse[1]) ? intval($url_parse[1]) : null;

    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            if (is_null($id)) {
                $data = Item::getAllItems();
            } else {
                $data = Item::getItem($id);
            }
            break;
        case 'POST':
            //$data = json_decode(file_get_contents('php://input'), true);
            $product= new Item(null, $_POST['name'], 0);
            $data = $product->save();
            break;
        case ($method == 'PATCH' || $method == 'PUT'):
            if (is_null($id)) {
                http_response_code(400);
                exit('ID is required for update!');
            }
            parse_str(file_get_contents('php://input'), $data);
            $product= new Item($id, null, $data['completed']);
            
            $product->update($id);
            break;
        case 'DELETE':
            if (is_null($id)) {
                http_response_code(400);
                exit('ID is required for delete!');
            }
            Item::delete($id);
            break;
        default:
            http_response_code(405);
            exit('Unsupported HTTP method.');
    }
} else {
    http_response_code(404);
    exit('Source is not defined!');
}

// JSON response
header('Content-Type: application/json');
echo json_encode($data);