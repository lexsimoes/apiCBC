<?php

class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'api1';
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die('Erro de conexão com o banco de dados: ' . $this->connection->connect_error);
        }
    }

    public function executeQuery($sql) {
        return $this->connection->query($sql);
    }

    public function getLastInsertedId() {
        return $this->connection->insert_id;
    }

    public function closeConnection() {
        $this->connection->close();
    }
}

?>
