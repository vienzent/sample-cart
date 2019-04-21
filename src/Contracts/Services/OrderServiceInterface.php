<?php declare(strict_types=1);

namespace App\Contracts\Services;


interface OrderServiceInterface
{
    public function getUserOrders(int $id) : array;
}