<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Worker;

use Denysov\Demo\Bootstrap\Kernel;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Spiral\RoadRunner\Environment\Mode;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Worker;

class HttpWorker
{
    private Kernel $kernel;

    public function __construct()
    {
        $this->kernel = new Kernel();
    }

    public function canServe(EnvironmentInterface $env): bool
    {
        return $env->getMode() === Mode::MODE_HTTP;
    }

    public function serve(): void
    {
        $factory = new Psr17Factory();
        $worker  = new PSR7Worker(Worker::create(), $factory, $factory, $factory);

        while (true) {
            try {
                $request = $worker->waitRequest();
                if ($request === null) {
                    break;
                }

                $worker->respond($this->kernel->handleRequest($request));
            } catch (\Throwable $e) {
                $worker->respond(new Response(400));
                continue;
            }
        }
    }
}