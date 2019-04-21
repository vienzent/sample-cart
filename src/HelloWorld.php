<?php declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class HelloWorld
{
    private $foo;

    private $response;

    public function __construct(
        string $foo,
        Response $response
    ) {
        $this->foo = $foo;
        $this->response = $response;
    }

    public function __invoke(): Response
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hello, {$this->foo} world!</body></html>");

        return $response;
    }

    public function test(Request $request): Response
    {

        $response = $this->response->withHeader('Content-Type', 'text/html');
        // var_dump($request);
        $foo = $request->getAttribute('foo');

        $response->getBody()
            ->write("<html><head></head><body>Hello, {$foo} world!</body></html>");
 
        return $response;
    }
}