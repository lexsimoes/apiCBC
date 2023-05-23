<?php

require_once '../config.php';
require_once '../database.php';
require_once '../controllers/clubeController.php';
require_once '../controllers/recursoController.php';

// Rota para listar todos os clubes
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'listar-clubes') {
    $clubeController = new ClubeController();
    $clubes = $clubeController->listarClubes();

    header('Content-Type: application/json');
    echo json_encode($clubes);
    exit;
}

// Rota para cadastrar um clube
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'cadastrar-clube') {
    $clubeController = new ClubeController();

    // Verifica se os dados foram enviados corretamente
    if (isset($_POST['clube']) && isset($_POST['saldo_disponivel'])) {
        $clube = $_POST['clube'];
        $saldo_disponivel = $_POST['saldo_disponivel'];

        $resultado = $clubeController->cadastrarClube($clube, $saldo_disponivel);

        if ($resultado) {
            header('HTTP/1.1 200 OK');
            echo "Clube cadastrado com sucesso.";
            exit;
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            echo "Erro ao cadastrar clube.";
            exit;
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo "Dados inválidos.";
        exit;
    }
}

// Rota para consumir recursos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'consumir-recursos') {
    $clubeController = new ClubeController();

    // Verifica se os dados foram enviados corretamente
    if (isset($_POST['clube_id']) && isset($_POST['recurso_id']) && isset($_POST['valor_consumo'])) {
        $clube_id = $_POST['clube_id'];
        $recurso_id = $_POST['recurso_id'];
        $valor_consumo = $_POST['valor_consumo'];

        $resultado = $clubeController->consumirRecursos($clube_id, $recurso_id, $valor_consumo);

        if ($resultado['status'] === 'success') {
            header('Content-Type: application/json');
            echo json_encode($resultado);
            exit;
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo $resultado['message'];
            exit;
        }
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo "Dados inválidos.";
        exit;
    }
}

// Rota para listar todos os recursos
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'listar-recursos') {
    $recursoController = new RecursoController();
    $recursos = $recursoController->listarRecursos();

    header('Content-Type: application/json');
    echo json_encode($recursos);
    exit;
}

// Rota não encontrada
header('HTTP/1.1 404 Not Found');
echo "Endpoint não encontrado.";
