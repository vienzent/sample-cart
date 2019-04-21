<?php declare(strict_types=1);

namespace App\Services;


use App\Contracts\Services\OrderServiceInterface;
use App\Repositories\OrderRepository;

class OrderService implements OrderServiceInterface
{
    protected $repo = null;

    public function __construct(OrderRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getUserOrders(int $id) : array
    {
        return $this->repo->getByUserId($id);
    }

}