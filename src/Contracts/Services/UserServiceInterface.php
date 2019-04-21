<?php declare(strict_types=1);

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function find(int $id) : ?User;
    public function update(User $user) : void;
    public function current(): User;
}