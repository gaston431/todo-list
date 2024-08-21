<?php

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'PATCH') {
    exit('error');
}

require '../database/Database.php';

$db = new Database;

$db->query('UPDATE todo_items SET completed = :completed WHERE id = :id', [
    'completed' => $_POST['completed'],
    'id' => $_POST['item_id']
]);

echo 'updated';