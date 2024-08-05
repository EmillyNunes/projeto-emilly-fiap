<?php

namespace App\Middleware;

use App\Utils\JWTUtil;
use Firebase\JWT\ExpiredException;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthMiddleware implements Middleware
{
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $authorizationHeader = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        try {
            $decoded = JWTUtil::decodeToken($token);
            $request = $request->withAttribute('user', $decoded);
        } catch (ExpiredException $e) {
            return $this->respondWithError('Token expirado', 401);
        } catch (\Exception $e) {
            return $this->respondWithError('Token inválido', 401);
        }

        return $handler->handle($request);
    }

    private function respondWithError($message, $statusCode): Response
    {
        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write(json_encode(['error' => $message]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
