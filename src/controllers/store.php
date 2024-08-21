<?php

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    exit('error');
}

require '../database/Database.php';

$db = new Database;

$db->query('INSERT INTO todo_items(name, completed) VALUES(:name, :completed)', [
    'name' => $_POST['name'],
    'completed' => 0
]);

$item_id = $db->connection->lastInsertId();

echo json_encode($item_id);