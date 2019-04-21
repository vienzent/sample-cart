<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CartItemNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct("Cart item {$id} not found");
    }
}