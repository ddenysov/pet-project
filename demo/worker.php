<?php

require __DIR__ . '/vendor/autoload.php';

use Denysov\Demo\Infrastructure\Worker\HttpWorker;
use Denysov\Demo\Infrastructure\Worker\JobsWorker;
use Spiral\RoadRunner\Environment;

$dispatchers = [
    new HttpWorker(),
    new JobsWorker(),
];

file_put_contents('test4.txt', 'ok');

// Create environment
$env = Environment::fromGlobals();

// Execute dispatcher that can serve the request
foreach ($dispatchers as $dispatcher) {
    if ($dispatcher->canServe($env)) {
        $dispatcher->serve();
    }
}