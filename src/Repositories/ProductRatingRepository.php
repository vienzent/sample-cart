<?php declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProductRatingRepositoryInterface;
use App\Models\Product;
use App\Models\ProductRating;
use Doctrine\ORM\EntityManager;

class ProductRatingRepository implements ProductRatingRepositoryInterface
{
    protected $manager = null;
    protected $repo = null;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(ProductRating::class);
    }

    public function insert(ProductRating $productRating): void
    {
        $this->manager->persist($productRating);
        $this->manager->flush();
    }

}