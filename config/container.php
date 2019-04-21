<?php declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

$containerBuilder->addDefinitions(__DIR__ . '/inject.php');
$container = $containerBuilder->build();

return $container;
