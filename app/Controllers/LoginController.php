<?php

namespace App\Controllers;

use App\Utils\JWTUtil;
use App\Database\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseFactoryInterface;

class LoginController
{
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function loginForm(Request $request, Response $response, $args): Response
    {
        ob_start();
        include __DIR__ . '/../Views/login.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }

    public function login(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? null;
        $senha = $data['senha'] ?? null;

        if (!$email || !$senha) {
            $response->getBody()->write(json_encode(['error' => 'Por favor, preencha todos os campos.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM admins WHERE email = ?');
        $stmt->execute([$email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($admin && password_verify($senha, $admin['password_hash'])) {
            $payload = [
                'id' => $admin['id'],
                'email' => $admin['email'],
                'exp' => time() + 3600
            ];
            $token = JWTUtil::createToken($payload);
            $response->getBody()->write(json_encode(['token' => $token]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['error' => 'Credenciais inválidas. Por favor, tente novamente.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }

    public function dashboard(Request $request, Response $response, $args): Response
    {
        ob_start();
        include __DIR__ . '/../Views/dashboard.php';
        $content = ob_get_clean();

        $response->getBody()->write($content);
        return $response;
    }
}