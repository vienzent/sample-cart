<?php declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Doctrine\ORM\EntityManager;

class ProductRepository implements ProductRepositoryInterface
{
    protected $manager = null;
    protected $repo = null;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(Product::class);
    }

    public function find(int $id): ?Product
    {
        return $this->repo->find($id);
    }

    public function all(): array
    {
        return $this->repo->findAll();
    }

    public function insert(Product $product): void
    {
        $this->manager->persist($product);
        $this->manager->flush();
    }

    public function update(Product $product) : void
    {
        $this->manager->merge($product);
        $this->manager->flush();
    }

    public function getProductsWithRatings(): array
    {
        $qb = $this->repo->createQueryBuilder("p");

        $query = $qb
            ->select('p.id, p.name, p.price, COUNT(r.id) as review_count, AVG(r.rate) as average_rate')
            ->leftJoin('p.ratings', 'r', 'WITH')
            ->groupBy('p.id')
            ->getQuery();


        $r = $query->getArrayResult();

        $products = [];

        foreach ($r as $product)
        {
            $products[] = new Product($product);
        }

        return $products;
    }

    public function getProductWithRating(int $id): Product
    {
        $qb = $this->repo->createQueryBuilder("p");

        $query = $qb
            ->select('p.id, p.name, p.price, COUNT(r.id) as review_count, AVG(r.rate) as average_rate')
            ->leftJoin('p.ratings', 'r', 'WITH')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->groupBy('p.id')
            ->getQuery();

        $data = $query->getSingleResult();

        return new Product($data);
    }
}