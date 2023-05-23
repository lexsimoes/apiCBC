<?php

require_once 'models/recursoModel.php';

class RecursoController {
    private $recursoModel;

    public function __construct() {
        $this->recursoModel = new RecursoModel();
    }

    public function listarRecursos() {
        return $this->recursoModel->listarRecursos();
    }
}
