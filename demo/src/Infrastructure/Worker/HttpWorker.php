<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Worker;

use App\RoadRunnerMode;
use Denysov\Demo\Container\SymfonyHttpKernel;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Log\LoggerInterface;
use Spiral\RoadRunner\Environment\Mode;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Worker;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Zinc\Core\Logging\Logger;

class HttpWorker
{


    private SymfonyHttpKernel                                         $kernel;
    private \Symfony\Component\DependencyInjection\ContainerInterface $container;
    private HttpFoundationFactory                                     $httpFactory;

    public function __construct()
    {
        $this->kernel  = new SymfonyHttpKernel('prod', false);
        $this->kernel->boot();
        $this->container = $this->kernel->getContainer();
        $this->httpFactory = new HttpFoundationFactory();
        $logger = $this->container->get(LoggerInterface::class);
        Logger::setLogger($logger);
    }

    public function canServe(EnvironmentInterface $env): bool
    {
        return $env->getMode() === Mode::MODE_HTTP;
    }

    public function serve(): void
    {
        file_put_contents('test2.txt', 'alalal');
        $factory = new Psr17Factory();
        $worker = new PSR7Worker(Worker::create(), $factory, $factory, $factory);

        while (true) {
            try {
                $request = $worker->waitRequest();
                if ($request === null) {
                    break;
                }

                $symfonyRequest = $this->httpFactory->createRequest($request);
                $symfonyResponse = $this->kernel->handle($symfonyRequest);

                $worker->respond(new Response($symfonyResponse->getStatusCode(), $symfonyResponse->headers->all(), $symfonyResponse->getContent()));
            } catch (\Throwable $e) {
                $worker->respond(new Response(400));
                continue;
            }
        }
    }
}