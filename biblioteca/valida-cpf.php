<?php
require_once dirname(__DIR__) . '/auth/verifica.php';

class CPFValidator
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Elimina CPFs inválidos conhecidos
        if (preg_match('/^(.)\1{10}$/', $cpf)) {
            return false;
        }

        // Calcula e verifica os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                return false;
            }
        }

        return true;
    }

    public function existeCpf($cpf)
    {
        $sql = "SELECT * FROM pacientes WHERE cpf = ?";
        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt) {
            die("Erro de conexão com o DB!");
        }

        $stmt->bind_param('s', $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return isset($row["id"]);
    }

    public function idCpf($cpf)
    {
        $sql = "SELECT id FROM pacientes WHERE cpf = ?";
        $stmt = $this->mysqli->prepare($sql);

        if (!$stmt) {
            die("Erro de conexão com o DB!");
        }

        $stmt->bind_param('s', $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return isset($row["id"]) ? $row["id"] : null;
    }
}

