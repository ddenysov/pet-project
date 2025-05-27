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
use Zinc\Core\Logging\Bridge\Print\PrintLogger;
use Zinc\Core\Logging\Logger;

$worker = Worker::create();

$factory = new Psr17Factory();

$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

$client      = new HttpClient();
$httpFactory = new HttpFoundationFactory();

//Logger::setLogger(new PrintLogger());

/** @var Symfony\Component\HttpKernel\HttpKernel $kernel */
$kernel  = new SymfonyHttpKernel('local', true);
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
        //
        $symfonyRequest = $httpFactory->createRequest($request);
        $symfonyResponse = $kernel->handle($symfonyRequest);

        $psr7->respond(new Response($symfonyResponse->getStatusCode(), $symfonyResponse->headers->all(), $symfonyResponse->getContent()));
    } catch (Throwable $e) {
        $psr7->respond(new Response(500, [], $e->getMessage()));
        $psr7->getWorker()->error((string) $e);
    }
}
