<?php

namespace App\Models;

use App\Database\Database;

class Turma
{
    private $id;
    private $nome;
    private $descricao;
    private $tipo;

    public function __construct($nome = null, $descricao = null, $tipo = null, $id = null)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function salvar()
    {
        $db = Database::getInstance();
        if ($this->id) {
            // Atualiza uma turma existente
            $stmt = $db->prepare('UPDATE turmas SET nome = :nome, descricao = :descricao, tipo = :tipo WHERE id = :id');
            $stmt->execute([
                ':nome' => $this->nome,
                ':descricao' => $this->descricao,
                ':tipo' => $this->tipo,
                ':id' => $this->id
            ]);
        } else {
            // Insere uma nova turma
            $stmt = $db->prepare('INSERT INTO turmas (nome, descricao, tipo) VALUES (:nome, :descricao, :tipo)');
            $stmt->execute([
                ':nome' => $this->nome,
                ':descricao' => $this->descricao,
                ':tipo' => $this->tipo
            ]);
            $this->id = $db->lastInsertId();
        }
    }

    public static function buscarPorId(int $id): ?Turma
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM turmas WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $turmaData = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($turmaData) {
            return new Turma($turmaData->nome, $turmaData->descricao, $turmaData->tipo, $turmaData->id);
        }
        return null;
    }

    public static function deletarPorId(int $id): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM turmas WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public static function todos()
    {
        $db = Database::getInstance();
        $stmt = $db->query('SELECT * FROM turmas');
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function buscarAlunosPorTurma(int $idTurma): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT alunos.*
            FROM alunos
            JOIN matriculas ON alunos.id = matriculas.id_aluno
            WHERE matriculas.id_turma = :id_turma
        ');
        $stmt->execute([':id_turma' => $idTurma]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
