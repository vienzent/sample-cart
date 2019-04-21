<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\ProductRatingRepositoryInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductRating;

class ProductService implements ProductServiceInterface
{
    protected $repo = null;
    protected $productRatingRepository;

    public function __construct(
        ProductRepositoryInterface $repo,
        ProductRatingRepositoryInterface $productRatingRepository
    )
    {
        $this->repo = $repo;
        $this->productRatingRepository = $productRatingRepository;
    }

    public function find(int $id): ?Product
    {
        return $this->repo->find($id);
    }

    public function all(): array
    {
        return $this->repo->all();
    }

    public function add(Product $product) : void
    {
        $this->repo->insert($product);
    }

    public function update(Product $product) : void
    {
        $this->repo->update($product);
    }

    public function addRating(ProductRating $productRating) : void
    {
        $this->productRatingRepository->insert($productRating);
    }

    public function getProductsWithRatings(): array
    {
        return $this->repo->getProductsWithRatings();
    }

    public function getProductWithRating(int $id): Product
    {
        return $this->repo->getProductWithRating($id);
    }
}