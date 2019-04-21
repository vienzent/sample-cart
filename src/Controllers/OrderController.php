<?php declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\Services\OrderServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\ShopServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Validator\ValidatorInterface;
use App\Contracts\Validator\ValidatorException;
use App\Contracts\View\EngineInterface as ViewEngine;
use App\Exceptions\CartItemNotFoundException;
use App\Models\CartItem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class OrderController extends Controller
{
    protected $orderService = null;
    protected $userService = null;

    public function __construct(
        ViewEngine $engine,
        Response $response,
        OrderServiceInterface $orderService,
        UserServiceInterface $userService
    )
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
        parent::__construct($engine, $response);
    }

    public function index() : Response
    {
        $orders = $this->orderService->getUserOrders(+$this->userService->current()->getId());
        return $this->view("order.index", compact('orders'));
    }
}