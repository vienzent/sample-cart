<?php declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use Doctrine\ORM\EntityManager;

class OrderRepository implements OrderRepositoryInterface
{
    protected $manager = null;
    protected $repo = null;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(Order::class);
    }

    public function find(int $id): ?Order
    {
        return $this->repo->find($id);
    }

    public function all(): array
    {
        return $this->repo->findAll();
    }

    public function insert(Order $order): void
    {
        $this->manager->persist($order);
        $this->manager->flush();
    }

    public function update(Order $order) : void
    {
        $this->manager->merge($order);
        $this->manager->flush();
    }

    public function getByUserId(int $id): array
    {
        return $this->repo->findBy(['user_id' => $id]);
    }


}