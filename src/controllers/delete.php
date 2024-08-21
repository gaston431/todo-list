<?php

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

if ($method !== 'DELETE') {
    exit('error');
}

require '../database/Database.php';

$db = new Database;

$db->query('delete from todo_items where id = :id', [
    'id' => $_POST['item_id']
]);

echo 'deleted';