<?php

require __DIR__ . '/vendor/autoload.php';


use Denysov\Demo\Container\SymfonyContainerFactory;
use Denysov\Demo\Container\SymfonyHttpKernel;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\HttpClient\HttpClient;

$worker = Worker::create();

$factory = new Psr17Factory();

$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

$client      = new HttpClient();
$httpFactory = new HttpFoundationFactory();

/** @var Symfony\Component\HttpKernel\HttpKernel $kernel */



new SymfonyHttpKernel('local', false);

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
        $container   = SymfonyContainerFactory::create();
        $kernel = $container->get('kernel');
        $symfonyRequest = $httpFactory->createRequest($request);

        // обработка ядром
        $symfonyResponse = $kernel->handle($symfonyRequest);


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
