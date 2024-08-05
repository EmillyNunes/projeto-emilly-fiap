<?php

namespace App\Models;

use App\Database\Database;

class Aluno
{
    private $id;
    private $nome;
    private $email;
    private $data_nascimento;

    public function __construct($nome = null, $email = null, $data_nascimento = null, $id = null)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->data_nascimento = $data_nascimento;
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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;
    }

    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    public function salvar()
    {
        $db = Database::getInstance();
        if ($this->id) {
            // Atualiza um aluno existente
            $stmt = $db->prepare('UPDATE alunos SET nome = :nome, email = :email, data_nascimento = :data_nascimento WHERE id = :id');
            $stmt->execute([
                ':nome' => $this->nome,
                ':email' => $this->email,
                ':data_nascimento' => $this->data_nascimento,
                ':id' => $this->id
            ]);
        } else {
            // Insere um novo aluno
            $stmt = $db->prepare('INSERT INTO alunos (nome, email, data_nascimento) VALUES (:nome, :email, :data_nascimento)');
            $stmt->execute([
                ':nome' => $this->nome,
                ':email' => $this->email,
                ':data_nascimento' => $this->data_nascimento
            ]);
            // Define o ID do aluno recém criado
            $this->id = $db->lastInsertId();
        }
    }

    public static function buscarPorId(int $id): ?Aluno
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM alunos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $alunoData = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($alunoData) {
            return new Aluno($alunoData->nome, $alunoData->email, $alunoData->data_nascimento, $alunoData->id);
        }
        return null;
    }

    public static function deletarPorId(int $id): void
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM alunos WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public static function todos(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query('
            SELECT alunos.*, turmas.nome AS turma_nome
            FROM alunos
            LEFT JOIN matriculas ON alunos.id = matriculas.id_aluno
            LEFT JOIN turmas ON matriculas.id_turma = turmas.id
        ');
        $alunos = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // Adiciona a turma ao objeto Aluno
        foreach ($alunos as $aluno) {
            $aluno->turma = $aluno->turma_nome;
        }

        return $alunos;
    }

    public static function buscarNaoMatriculados(): array
    {
        $db = Database::getInstance();
        $stmt = $db->query('
            SELECT * FROM alunos 
            WHERE id NOT IN (SELECT id_aluno FROM matriculas)
        ');
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function buscarPorEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM alunos WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $resultado = $stmt->fetch($db::FETCH_ASSOC);

        if ($resultado) {
            $aluno = new self();
            $aluno->id = $resultado['id'];
            $aluno->nome = $resultado['nome'];
            $aluno->email = $resultado['email'];
            $aluno->data_nascimento = $resultado['data_nascimento'];
            return $aluno;
        }
        return null;
    }

    public static function emailExiste($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT COUNT(*) FROM alunos WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
