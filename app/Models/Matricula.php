<?php

namespace App\Models;

use App\Database\Database;

class Matricula
{
    public $id_turma;
    public $id_aluno;

    public function salvar()
    {
        $db = Database::getInstance();
        $db->beginTransaction();

        try {
            if ($this->verificarMatriculaExistente()) {
                // Atualiza a matrícula existente
                $stmt = $db->prepare('UPDATE matriculas SET id_turma = :id_turma WHERE id_aluno = :id_aluno');
                $stmt->execute([
                    ':id_turma' => $this->id_turma,
                    ':id_aluno' => $this->id_aluno
                ]);
            } else {
                // Insere uma nova matrícula
                $stmt = $db->prepare('INSERT INTO matriculas (id_aluno, id_turma) VALUES (:id_aluno, :id_turma)');
                $stmt->execute([
                    ':id_aluno' => $this->id_aluno,
                    ':id_turma' => $this->id_turma
                ]);
            }

            $db->commit();
            return true;
        } catch (\Exception $e) {
            $db->rollBack();
            error_log('Erro ao salvar matrícula: ' . $e->getMessage());
            return false;
        }
    }

    private function verificarMatriculaExistente()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT COUNT(*) FROM matriculas WHERE id_aluno = :id_aluno');
        $stmt->execute([':id_aluno' => $this->id_aluno]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public static function buscarPorAluno($id_aluno)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM matriculas WHERE id_aluno = :id_aluno');
        $stmt->execute([':id_aluno' => $id_aluno]);
        return $stmt->fetchObject(self::class);
    }


    public static function deletarPorAluno($id_aluno)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM matriculas WHERE id_aluno = :id_aluno');
        $stmt->execute([':id_aluno' => $id_aluno]);
    }

}
