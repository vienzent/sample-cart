<?php declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\OrderLine;

interface OrderLineRepositoryInterface
{
    public function find(int $id) : ?OrderLine;
    public function all() : array;
    public function insert(OrderLine $orderLine) : void;
    public function update(OrderLine $orderLine) : void;
}