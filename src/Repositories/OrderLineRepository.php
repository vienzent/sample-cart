<?php declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\OrderLineRepositoryInterface;
use App\Models\OrderLine;
use Doctrine\ORM\EntityManager;

class OrderLineRepository implements OrderLineRepositoryInterface
{
    protected $manager = null;
    protected $repo = null;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(OrderLine::class);
    }

    public function find(int $id): ?OrderLine
    {
        return $this->repo->find($id);
    }

    public function all(): array
    {
        return $this->repo->findAll();
    }

    public function insert(OrderLine $orderLine): void
    {
        $this->manager->persist($orderLine);
        $this->manager->flush();
    }

    public function update(OrderLine $orderLine) : void
    {
        $this->manager->merge($orderLine);
        $this->manager->flush();
    }
}