<?php declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

class HomeController extends Controller
{

    public function __invoke(): Response
    {
        return $this->view("home");
    }
}