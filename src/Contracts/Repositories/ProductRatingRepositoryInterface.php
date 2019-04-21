<?php declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\ProductRating;

interface ProductRatingRepositoryInterface
{
    public function insert(ProductRating $productRating) : void;
}