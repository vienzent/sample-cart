<?php declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function find(int $id) : ?User;
    public function all() : array;
    public function insert(User $user) : void;
    public function update(User $user) : void;
}