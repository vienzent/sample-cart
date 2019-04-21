<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Exceptions\NoCurrentUserException;
use App\Models\User;

class UserService implements UserServiceInterface
{
    protected $repo = null;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function find(int $id): ?User
    {
        return $this->repo->find($id);
    }

    public function update(User $user): void
    {
        $this->repo->update($user);
    }

    public function current(): User
    {
        If(!isset($_SESSION['user_id']))
        {
            throw new NoCurrentUserException();
        }

        $user = $this->repo->find(+$_SESSION['user_id']);

        if($user == null)
        {
            throw new NoCurrentUserException();
        }

        return $user;
    }


}