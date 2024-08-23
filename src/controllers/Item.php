<?php

// Item Class
class Item {
    private $id;
    private $name;
    private $completed;

    public function __construct($id, $name, $completed) {
        $this->id = $id;
        $this->name = $name;
        $this->completed = $completed;
    }

    // CRUD
    public static function getAllItems() {
        global $db;
        /* $sql = "SELECT * FROM todo_items";
        $result = $db->query($sql);

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = new Item($row['id'], $row['name'], $row['completed']);
        } */

        $items = $db->query('select * from todo_items')->get();

        return $items;
    }

    public static function getItem($id) {
        global $db;
        /* $sql = "SELECT * FROM todo_items WHERE id = $id";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Item($row['id'], $row['name'], $row['completed']);
        } else {
            return null;
        } */

        $item = $db->query('select * from todo_items where id = :id', [
            'id' => $id
        ])->find();

        return $item;
    }

    public function save() {
        global $db;
        /* $sql = "INSERT INTO todo_items(name, completed) VALUES ('$this->name', $this->completed)";
        $db->query($sql); */

        $db->query('INSERT INTO todo_items(name, completed) VALUES(:name, :completed)', [
            'name' => $this->name,
            'completed' => 0
        ]);

        return $db->connection->lastInsertId();
    }

    public function update($id) {
        global $db;
        /* $sql = "UPDATE todo_items SET completed = $this->completed WHERE id = $id";
        $db->query($sql); */

        $db->query('UPDATE todo_items SET completed = :completed WHERE id = :id', [
            'completed' => $this->completed,
            'id' => $id
        ]);
    }

    public static function delete($id) {
        global $db;
        /* $sql = "DELETE FROM todo_items WHERE id = $id";
        $db->query($sql); */

        $db->query('delete from todo_items where id = :id', [
            'id' => $id
        ]);
    }
}