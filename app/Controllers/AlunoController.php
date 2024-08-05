<?php

namespace App\Controllers;

use App\Models\Aluno;
use App\Models\Matricula;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunoController
{
    public function index(Request $request, Response $response, $args)
    {
        $alunos = Aluno::todos();

        ob_start();
        include __DIR__ . '/../Views/alunos/index.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }

    // Inclui o formulário para adicionar um novo aluno
    public function adicionarForm(Request $request, Response $response, $args)
    {
        ob_start();
        include __DIR__ . '/../Views/alunos/adicionar.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }

    // Valida o nome do aluno (3 caracteres)
    private function validarNome($nome)
    {
        return strlen($nome) >= 3;
    }

    public function adicionar(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $nome = $data['nome'] ?? null;
        $email = $data['email'] ?? null;
        $data_nascimento = $data['data_nascimento'] ?? null;
        $turma_id = $data['turma_id'] ?? null;

        if (Aluno::emailExiste($email)) {
            $response->getBody()->write('Erro: E-mail já cadastrado.');
            return $response;
        }

        // Cria o novo aluno
        $aluno = new Aluno($nome, $email, $data_nascimento);
        $aluno->salvar();

        // Cria a matrícula se uma turma for selecionada
        if ($turma_id) {
            $matricula = new Matricula();
            $matricula->id_turma = $turma_id;
            $matricula->id_aluno = $aluno->getId();
            $matricula->salvar();
        }

        return $response->withHeader('Location', '/alunos')->withStatus(302);
    }

    public function atualizarForm(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $aluno = Aluno::buscarPorId($id);
        if ($aluno) {
            // Obtém a matrícula atual do aluno
            $matriculaAtual = Matricula::buscarPorAluno($id);

            ob_start();
            include __DIR__ . '/../Views/alunos/atualizar.php';
            $content = ob_get_clean();

            $response->getBody()->write($content);
            return $response;
        }
        return $response->withStatus(404);
    }

    // Deleta um aluno
    public function deletar(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        Aluno::deletarPorId($id);

        return $response->withHeader('Location', '/alunos')->withStatus(302);
    }

    public function atualizar(Request $request, Response $response, $args)
    {
        $id = (int) $args['id'];
        $data = $request->getParsedBody();

        if (!$this->validarNome($data['nome'])) {
            return $response->withStatus(400);
        }

        // Atualiza as informações do aluno
        $aluno = Aluno::buscarPorId($id);
        if ($aluno) {
            $aluno->setNome($data['nome']);
            $aluno->setEmail($data['email']);
            $aluno->setDataNascimento($data['data_nascimento']);
            $aluno->salvar();

            // Verifica se uma nova turma foi selecionada
            $novaTurma = !empty($data['turma']) ? (int) $data['turma'] : null;

            // Obtém a matrícula atual do aluno
            $matriculaAtual = Matricula::buscarPorAluno($id);

            if ($novaTurma) {
                if ($matriculaAtual) {
                    if ($matriculaAtual->id_turma !== $novaTurma) {
                        // Atualiza a matrícula existente
                        $matriculaAtual->id_turma = $novaTurma;
                        $matriculaAtual->salvar();
                    }
                } else {
                    // Cria uma nova matrícula se o aluno não tiver uma
                    $matricula = new Matricula();
                    $matricula->id_turma = $novaTurma;
                    $matricula->id_aluno = $id;
                    $matricula->salvar();
                }
            } elseif ($matriculaAtual) {
                // Remove a matrícula se nenhuma turma for selecionada
                Matricula::deletarPorAluno($id);
            }
        }

        return $response->withHeader('Location', '/alunos')->withStatus(303);
    }

}
