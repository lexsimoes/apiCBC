<?php

require_once 'database.php';

class ClubeModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function cadastrarClube($clube, $saldo_disponivel) {
        $clube = $this->db->escapeString($clube);
        $saldo_disponivel = floatval($saldo_disponivel);

        $sql = "INSERT INTO Clube (clube, saldo_disponivel) VALUES ('$clube', $saldo_disponivel)";

        $result = $this->db->executeQuery($sql);
        echo $this->db->getError(); // verificar erro do BD

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function listarClubes() {
        $sql = "SELECT * FROM Clube";
        $result = $this->db->executeQuery($sql);

        $clubes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clubes[] = $row;
            }
        }

        return $clubes;
    }

    public function consumirRecursos($clube_id, $recurso_id, $valor_consumo) {
        $clube_id = intval($clube_id);
        $recurso_id = intval($recurso_id);
        $valor_consumo = floatval($valor_consumo);

        // Verifica se o clube possui saldo suficiente
        $saldo_disponivel = $this->getSaldoDisponivel($clube_id);
        if ($saldo_disponivel < $valor_consumo) {
            return "O saldo disponível do clube é insuficiente.";
        }

        // Atualiza o saldo disponível do clube
        $novo_saldo = $saldo_disponivel - $valor_consumo;
        $sql = "UPDATE Clube SET saldo_disponivel = $novo_saldo WHERE id = $clube_id";
        $this->db->executeQuery($sql);

        // Atualiza o saldo disponível do recurso
        $recurso_saldo = $this->getRecursoSaldo($recurso_id);
        $novo_recurso_saldo = $recurso_saldo - $valor_consumo;
        $sql = "UPDATE Recurso SET saldo_disponivel = $novo_recurso_saldo WHERE id = $recurso_id";
        $this->db->executeQuery($sql);

        return true;
    }

    private function getSaldoDisponivel($clube_id) {
        $sql = "SELECT saldo_disponivel FROM Clube WHERE id = $clube_id";
        $result = $this->db->executeQuery($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return floatval($row['saldo_disponivel']);
        }

        return 0.0;
    }

    private function getRecursoSaldo($recurso_id) {
        $sql = "SELECT saldo_disponivel FROM Recurso WHERE id = $recurso_id";
        $result = $this->db->executeQuery($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return floatval($row['saldo_disponivel']);
        }

        return 0.0;
    }
}

?>
