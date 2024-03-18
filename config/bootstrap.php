<?php

declare(strict_types=1);

use App\Config\Config;
use App\Core\App;
use App\DB\Connection;

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Config($_ENV);

$container = require __DIR__ . '/services.php';
$connection = Connection::getInstance($config->db);

$router = require __DIR__ . '/routes.php';

return new App($router);
