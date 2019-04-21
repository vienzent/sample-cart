<?php declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\Product;
use App\Models\ProductRating;

interface ProductServiceInterface
{
    public function find(int $id) : ?Product;
    public function all() : array;
    public function add(Product $product) : void;
    public function update(Product $product) : void;
    public function addRating(ProductRating $productRating) : void;
    public function getProductsWithRatings(): array;
    public function getProductWithRating(int $id): Product;
}