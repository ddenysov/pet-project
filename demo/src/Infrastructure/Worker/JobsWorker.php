<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Worker;

use Denysov\Demo\Container\SymfonyHttpKernel;
use Denysov\Demo\Domain\Model\Ping\Event\PingCreated;
use Denysov\Demo\Domain\Model\Ping\PingId;
use Psr\Log\LoggerInterface;
use Spiral\RoadRunner\Environment\Mode;
use Spiral\RoadRunner\EnvironmentInterface;
use Spiral\RoadRunner\Jobs\Consumer;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\AckStamp;
use Symfony\Component\Messenger\Stamp\ConsumedByWorkerStamp;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\EventBusInterface;
use Zinc\Core\Logging\Logger;

class JobsWorker
{
    private SymfonyHttpKernel                                         $kernel;
    private \Symfony\Component\DependencyInjection\ContainerInterface $container;
    private HttpFoundationFactory                                     $httpFactory;
    private SerializerInterface                                       $serializer;
    private array                                                     $acks;


    public function __construct()
    {
        $this->kernel = new SymfonyHttpKernel('local', true);
        $this->kernel->boot();
        $this->container   = $this->kernel->getContainer();
        $this->httpFactory = new HttpFoundationFactory();
        $logger            = $this->container->get(LoggerInterface::class);
        Logger::setLogger($logger);
    }

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
                $payload = json_decode($task->getPayload());
                Logger::debug('TASK RECEIVED', [
                    'id'    => $task->getId(),
                    'class' => $payload->event,
                ]);
                $envelope = new Envelope(new PingCreated(PingId::create()));
                $eventBus = $this->container->get('messenger.default_bus');

                Logger::debug('ENVELOPE', [
                    'envelope' => $envelope,
                ]);


                $acked = false;
                $ack = function (Envelope $envelope, ?\Throwable $e = null) use (&$acked) {
                    $acked = true;
                    $this->acks[] = ['rr', $envelope, $e];
                };

                try {
                    $e = null;
                    $envelope = $eventBus->dispatch($envelope->with(new ReceivedStamp('rr'), new ConsumedByWorkerStamp(), new AckStamp($ack)));
                } catch (\Throwable $e) {
                    Logger::error($e->getMessage());
                }



                // Handle and process task. Here we just print payload.

                // Complete task.
                $task->ack();
            } catch (\Throwable $e) {
                $task->fail($e);
            }
        }
    }
}