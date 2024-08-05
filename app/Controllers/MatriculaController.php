<?php
namespace App\Controllers;

use App\Models\Matricula;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MatriculaController
{
    public function adicionar(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $id_turma = $data['turma_id'];
        $id_aluno = $data['aluno_id'];

        // Criar a nova matrícula
        $matricula = new Matricula();
        $matricula->id_turma = $id_turma;
        $matricula->id_aluno = $id_aluno;

        // Salvar a matrícula no banco de dados
        if ($matricula->salvar()) {
            return $response->withHeader('Location', '/turmas/visualizar/' . $id_turma . '?status=success')->withStatus(302);
        } else {
            return $response->withHeader('Location', '/turmas/visualizar/' . $id_turma . '?status=error')->withStatus(302);
        }
    }
}

