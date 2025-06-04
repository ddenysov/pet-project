<?php
declare(strict_types=1);

namespace Zinc\Core\Worker\Roadrunner;

use Spiral\RoadRunner\Environment;

class Dispatcher
{
    private array $workers = [];

    private const WORKER_CLASSES = [
        HttpWorker::class,
        JobsWorker::class,
    ];

    public function __construct(array $options = [])
    {
        foreach (self::WORKER_CLASSES as $class) {
            $this->workers[] = new $class($options);
        }
    }

    public function dispatch(): void
    {
        $env = Environment::fromGlobals();

        // Execute dispatcher that can serve the request
        foreach ($this->workers as $worker) {
            if ($worker->canServe($env)) {
                $worker->serve();
            }
        }
    }
}