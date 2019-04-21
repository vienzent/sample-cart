<?php declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\Validator\ValidatorException;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\View\EngineInterface as ViewEngine;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

class Controller 
{
    protected $engine = null;
    protected $response = null;

    public function __construct(ViewEngine $engine, Response $response)
    {
        $this->engine = $engine;
        $this->response = $response;
    }

    public function view(string $path, array $data = []) : Response
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');

        $response->getBody()
            ->write($this->engine->get($path, $data));

        return $response;
    }

    public function redirect(string $uri , array $data = []) : Response
    {
        $query = http_build_query($data);

        if($query) $uri .= "?" . $query;

        return new RedirectResponse($uri);
    }

    public function notFound($message = 'Not Found') : Response
    {
        return new HtmlResponse($this->engine->get('errors.404', compact('message')), 404);
    }
}