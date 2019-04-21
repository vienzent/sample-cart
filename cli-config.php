<?php

require_once __DIR__ . "/vendor/autoload.php";

$entityManager = require_once __DIR__ . '/config/doctrine.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
