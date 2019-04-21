<?php declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\CartItem;

interface ShopServiceInterface
{
    public function addItem(CartItem $cartItem) : void;
    public function updateItem(CartItem $cartItem) : void;
    public function findItem(int $id) : CartItem;
    public function getItems() : array;
    public function deleteItem(int $id) : void;
    public function subTotal() : float;
    public function checkout(string $shipping_fee): void;
}