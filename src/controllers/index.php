<?php

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    exit('error');
}

require '../database/Database.php';

$db = new Database;

$items = $db->query('select * from todo_items')->get();

echo json_encode($items);