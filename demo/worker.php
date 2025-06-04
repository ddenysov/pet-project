<?php

require __DIR__ . '/vendor/autoload.php';

use Zinc\Core\Worker\Roadrunner\Dispatcher;

$dispatcher = new Dispatcher(['base_dir' => __DIR__]);
$dispatcher->dispatch();
