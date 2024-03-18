<?php
declare(strict_types=1);

$app = require __DIR__ . '/../config/bootstrap.php';

const APP_ROOT = __DIR__ . '/..';
const VIEW_PATH = APP_ROOT . '/views/';

echo $app->execute();
