<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Worker;

use Spiral\RoadRunner\Environment\Mode;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunner\Jobs\Consumer;
use Zinc\Core\Logging\Logger;

class JobsWorker
{
    public function canServe(EnvironmentInterface $env): bool
    {
        file_put_contents('testB1.txt', $env->getMode());
        return $env->getMode() === Mode::MODE_JOBS;
    }

    public function serve(): void
    {
        file_put_contents('testA1.txt', 'started');
        $consumer = new Consumer();

        while ($task = $consumer->waitTask()) {
            try {
                file_put_contents('test_received.txt', 'task');
                // Handle and process task. Here we just print payload.

                // Complete task.
                $task->complete();
            } catch (\Throwable $e) {
                $task->fail($e);
            }
        }
    }
}