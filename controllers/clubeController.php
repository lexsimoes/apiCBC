<?php

require_once 'models/clubeModel.php';

class ClubeController {
    private $clubeModel;

    public function __construct() {
        $this->clubeModel = new ClubeModel();
    }
    public function cadastrarClube() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $clube = $_POST['clube'];
          $saldo_disponivel = $_POST['saldo_disponivel'];

          $result = $this->clubeModel->cadastrarClube($clube, $saldo_disponivel);

          if ($result) {
              echo 'Clube cadastrado com sucesso!';
          } else {
              echo 'Erro ao cadastrar clube.';
          }
      }
  }

  public function listarClubes() {
      $clubes = $this->clubeModel->listarClubes();

      if (!empty($clubes)) {
          foreach ($clubes as $clube) {
              echo 'ID: ' . $clube['id'] . ', Clube: ' . $clube['clube'] . ', Saldo Disponível: ' . $clube['saldo_disponivel'] . '<br>';
          }
      } else {
          echo 'Nenhum clube cadastrado.';
      }
  }

  public function consumirRecursos() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $clube_id = $_POST['clube_id'];
          $recurso_id = $_POST['recurso_id'];
          $valor_consumo = $_POST['valor_consumo'];

          $result = $this->clubeModel->consumirRecursos($clube_id, $recurso_id, $valor_consumo);

          if ($result === true) {
              echo 'Recursos consumidos com sucesso!';
          } else {
              echo $result;
          }
      }
  }
}

$clubeController = new ClubeController();

// Rota para cadastrar um clube
if (isset($_GET['action']) && $_GET['action'] === 'cadastrar') {
  $clubeController->cadastrarClube();
}

// Rota para listar todos os clubes
if (isset($_GET['action']) && $_GET['action'] === 'listar') {
  $clubeController->listarClubes();
}

// Rota para consumir recursos
if (isset($_GET['action']) && $_GET['action'] === 'consumir') {
  $clubeController->consumirRecursos();
}

?>
