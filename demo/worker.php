<?php

require __DIR__ . '/vendor/autoload.php';

use Denysov\Demo\Container\ContainerFactory;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;

$worker = Worker::create();

$factory = new Psr17Factory();

$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);
$container = ContainerFactory::create();

while (true) {
    try {
        $request = $psr7->waitRequest();
        if ($request === null) {
            break;
        }
    } catch (Throwable $e) {
        $psr7->respond(new Response(400));
        continue;
    }

    try {
        $psr7->respond(new Response(200, [], json_encode(
            [
                'status' => 'ok',
            ],
            JSON_PRETTY_PRINT
        )));
    } catch (Throwable $e) {
        $psr7->respond(new Response(500, [], $e->getMessage()));
        $psr7->getWorker()->error((string) $e);
    }
}
