<?php declare(strict_types=1);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__.'/../src/Models'], $isDevMode, null, null, false);

return EntityManager::create([
    // 'driver' => 'pdo_sqlite',
    // 'path' => __DIR__ . '/../database/db.sqlite',
    'dbname' => 'cart',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
], $config);

