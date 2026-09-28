<?php
declare(strict_types=1);
require dirname(__DIR__) . '/vendor/autoload.php';

use Lila\\Config\\Env;
use Lila\\Http\\Request;
use Lila\\Kernel;

$kernel = new Kernel(Env::fromEnvironment());
$kernel->handle(Request::fromGlobals())->send();
