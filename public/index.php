<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use App\Middleware\AuthMiddleware;
use App\Controllers\LoginController;
use App\Controllers\AlunoController;
use App\Controllers\TurmaController;
use App\Controllers\MatriculaController;
use Psr\Http\Message\ResponseFactoryInterface;
use DI\Container;
use Slim\Middleware\ErrorMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$container->set(ResponseFactoryInterface::class, function () {
    return new \Slim\Psr7\Factory\ResponseFactory();
});

// Middleware para lidar com métodos HTTP
$app->add(function ($request, $handler) {
    $method = $request->getParsedBody()['_METHOD'] ?? $request->getMethod();
    if ($method !== $request->getMethod()) {
        $request = $request->withMethod($method);
    }
    return $handler->handle($request);
});

$authMiddleware = new AuthMiddleware($container->get(ResponseFactoryInterface::class));

// Rotas Alunos
$app->get('/alunos', [AlunoController::class, 'index']);
$app->get('/alunos/adicionar', [AlunoController::class, 'adicionarForm']);
$app->post('/alunos/adicionar', [AlunoController::class, 'adicionar']);
$app->get('/alunos/atualizar/{id}', [AlunoController::class, 'atualizarForm']);
$app->put('/alunos/atualizar/{id}', [AlunoController::class, 'atualizar']);
$app->delete('/alunos/deletar/{id}', [AlunoController::class, 'deletar']);

// Rotas Turmas
$app->get('/turmas', [TurmaController::class, 'index']);
$app->get('/turmas/json', [TurmaController::class, 'getTurmasJson']);
$app->get('/turmas/adicionar', [TurmaController::class, 'adicionarForm']);
$app->post('/turmas/adicionar', [TurmaController::class, 'adicionar']);
$app->get('/turmas/atualizar/{id}', [TurmaController::class, 'atualizarForm']);
$app->put('/turmas/atualizar/{id}', [TurmaController::class, 'atualizar']);
$app->delete('/turmas/deletar/{id}', [TurmaController::class, 'deletar']);
$app->get('/turmas/visualizar/{id}', [TurmaController::class, 'visualizarAlunos']);


// Rotas Matrículas
$app->post('/matriculas/adicionar', [MatriculaController::class, 'adicionar']);

// Rotas Login
$app->get('/login', [LoginController::class, 'loginForm']);
$app->post('/login', [LoginController::class, 'login']);
$app->get('/dashboard', [LoginController::class, 'dashboard']);

// Middleware de erro
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();