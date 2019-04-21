<?php declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function find(int $id) : ?Product;
    public function all() : array;
    public function insert(Product $product) : void;
    public function update(Product $product) : void;
    public function getProductsWithRatings(): array;
    public function getProductWithRating(int $id): Product;
}