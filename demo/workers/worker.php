<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Zinc\Core\Worker\Roadrunner\Dispatcher;

$dispatcher = new Dispatcher(['base_dir' => dirname(__DIR__)]);
$dispatcher->dispatch();
