<?php

require_once 'database.php';

class RecursoModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function listarRecursos() {
        $sql = "SELECT * FROM Recurso";
        $result = $this->db->executeQuery($sql);

        $recursos = array();
        while ($row = $result->fetch_assoc()) {
            $recursos[] = $row;
        }

        return $recursos;
    }
}
