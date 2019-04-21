<?php declare(strict_types=1);

namespace App\Contracts\View;

interface EngineInterface
{
    public function get(string $path, array $data = []) : string;
}