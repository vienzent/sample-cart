<?php declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Doctrine\ORM\EntityManager;

class UserRepository implements UserRepositoryInterface
{
    protected $manager = null;
    protected $repo = null;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->repo = $manager->getRepository(User::class);
    }

    public function find(int $id): ?User
    {
        return $this->repo->find($id);
    }

    public function all(): array
    {
        return $this->repo->findAll();
    }

    public function insert(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function update(User $user) : void
    {
        $this->manager->merge($user);
        $this->manager->flush();
    }
}