<?php

// Controle de acesso de importação de componente.
require_once dirname(__DIR__) . '/auth/access_control.php';

class CPFValidator
{
    private $mysqli;

    // Construtor com o $mysqli opcional
    public function __construct($mysqli = null)
    {
        // Se o parâmetro não for passado, a conexão com o banco não será usada
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

    // Verifica se o CPF já existe no banco (quando a conexão com o DB for passada)
    public function existeCpf($cpf)
    {
        if ($this->mysqli === null) {
            return false; // Se não há conexão com o DB, retornamos falso
        }

        $sql = "SELECT * FROM pacientes WHERE cpf = ?";
        $stmt = $this->mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("Erro de conexão com o DB!");
        }

        $stmt->bind_param("s", $cpf); // Previne SQL injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return isset($row["id"]);
    }

    // Retorna o ID do paciente pelo CPF (quando a conexão com o DB for passada)
    public function idCpf($cpf)
    {
        if ($this->mysqli === null) {
            return null; // Se não há conexão com o DB, retornamos null
        }

        $sql = "SELECT id FROM pacientes WHERE cpf = ?";
        $stmt = $this->mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            die("Erro de conexão com o DB!");
        }

        $stmt->bind_param("s", $cpf); // Previne SQL injection
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();

        return isset($row["id"]) ? $row["id"] : null;
    }
}
