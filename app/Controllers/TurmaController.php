<?php

namespace App\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TurmaController
{
    public function index(Request $request, Response $response, $args)
    {
        $turmas = Turma::todos();

        ob_start();
        include __DIR__ . '/../Views/turmas/index.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }

    // Inclui o formulário para adicionar uma nova turma
    public function adicionarForm(Request $request, Response $response, $args)
    {
        ob_start();
        include __DIR__ . '/../Views/turmas/adicionar.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }

    // Adiciona a nova turma
    public function adicionar(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $turma = new Turma($data['nome'], $data['descricao'], $data['tipo']);
        $turma->salvar();
        return $response->withHeader('Location', '/turmas')->withStatus(302);
        ; // Retorna um status 201 Created
    }

    public function atualizarForm(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $turma = Turma::buscarPorId($id);
        if ($turma) {
            ob_start();
            include __DIR__ . '/../Views/turmas/atualizar.php';
            $content = ob_get_clean();

            $response->getBody()->write($content);
            return $response;
        }
        return $response->withStatus(404);
    }

    // Atualiza os dados de uma turma existente
    public function atualizar(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        $turma = Turma::buscarPorId($id);
        if ($turma) {
            $turma->setNome($data['nome']);
            $turma->setDescricao($data['descricao']);
            $turma->setTipo($data['tipo']);
            $turma->salvar();
        }

        return $response->withHeader('Location', '/turmas')->withStatus(302);
    }

    // Deleta a turma
    public function deletar(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        Turma::deletarPorId($id);

        return $response->withHeader('Location', '/turmas')->withStatus(302);
    }

    // Busca os alunos matriculados na turma e busca os alunos que ainda não foram matriculados em nenhuma turma
    public function visualizarAlunos(Request $request, Response $response, $args)
    {
        $idTurma = (int) $args['id'];

        // Verifica se o ID da turma é válido
        if ($idTurma <= 0) {
            return $response->withStatus(404);
        }

        // Busca os dados da turma
        $turma = Turma::buscarPorId($idTurma);
        if (!$turma) {
            return $response->withStatus(404);
        }

        // Busca os alunos matriculados na turma
        $alunos = Turma::buscarAlunosPorTurma($idTurma);

        // Busca os alunos que ainda não foram matriculados em nenhuma turma
        $alunosNaoMatriculados = Aluno::buscarNaoMatriculados();

        ob_start();
        include __DIR__ . '/../Views/turmas/visualizar.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);

        return $response;
    }

    public function getTurmasJson(Request $request, Response $response, $args)
    {
        $turmas = Turma::todos();

        $turmasArray = [];
        foreach ($turmas as $turma) {
            $turmasArray[] = [
                'id' => $turma->id,
                'nome' => $turma->nome
            ];
        }

        $response->getBody()->write(json_encode($turmasArray));
        return $response->withHeader('Content-Type', 'application/json');
    }

}
