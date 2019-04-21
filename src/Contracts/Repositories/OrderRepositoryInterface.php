<?php declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function find(int $id) : ?Order;
    public function all() : array;
    public function insert(Order $order) : void;
    public function update(Order $order) : void;
    public function getByUserId(int $id) : array;
}