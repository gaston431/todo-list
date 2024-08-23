<?php

/* namespace Core;

use PDO; */

class Database
{
    public $connection;
    public $statement;

    public function __construct(/* $config ,*/ $username = 'root', $password = 'todos')
    {
        // Read the database connection parameters from environment variables
        $db_host = getenv('DB_HOST');
        $db_name = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password_file_path = getenv('PASSWORD_FILE_PATH');
        // Read the password from the file
        $password = trim(file_get_contents($password_file_path));

        //$dsn = 'mysql:' . http_build_query($config, '', ';');
        $dsn = "mysql:host={$db_host};dbname={$db_name}";
        
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $this->connection->exec("
        CREATE TABLE IF NOT EXISTS todo_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            completed TINYINT(1) NOT NULL
        )
        ");
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    /* public function findOrFail()
    {
        $result = $this->find();

        if (! $result) {
            abort();
        }

        return $result;
    } */
}