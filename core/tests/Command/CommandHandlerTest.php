<?php


namespace Tests\Command;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Stub\DummyCommand;
use Tests\Stub\DummyCommandHandler;
use Zinc\Core\Command\Bridge\InMemory\InMemoryCommandBus;
use Zinc\Core\Command\Decorator\RetryCommandHandlerDecorator;
use Zinc\Core\Command\Persistence\AggregatePersistenceManager;
use Zinc\Core\Command\Proxy\CommandHandler\LoggerProxyCommandHandler;
use Zinc\Core\DataStore\Bridge\InMemory\InMemoryDataStore;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\Bridge\InMemory\InMemoryEventBus;
use Zinc\Core\Event\EventStore;
use Zinc\Core\Event\Proxy\LoggingEventBusProxy;
use Zinc\Core\Event\Proxy\LoggingEventStoreProxy;
use Zinc\Core\Logging\Bridge\Print\PrintLogger;
use Zinc\Core\Logging\LogManager;
use Zinc\Core\Message\Outbox\Outbox;
use Zinc\Core\Message\Outbox\Proxy\LoggingOutboxProxy;
use Zinc\Core\Repository\EventStoreRepository;
use Zinc\Core\Repository\Proxy\LoggingRepositoryProxy;

class CommandHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testName()
    {
        $command       = new DummyCommand(Uuid::create()->toString());
        $logger        = new PrintLogger();
        $logManager = new LogManager($logger);
        $mockDataStore = new InMemoryDataStore();

        $eventStore = new LoggingEventStoreProxy(new EventStore($mockDataStore), $logManager);
        $repository = new EventStoreRepository($eventStore);
        $outbox     = new Outbox($mockDataStore);
        $eventBus   = new InMemoryEventBus();

        $handler = new DummyCommandHandler(
            new AggregatePersistenceManager(
                new LoggingRepositoryProxy($repository, $logManager),
                new LoggingOutboxProxy($outbox, $logManager),
                new LoggingEventBusProxy($eventBus, $logManager),
                $mockDataStore,
            ),
        );
        $handler = new LoggerProxyCommandHandler(
            $handler,
            $logger,
            'Handle command',
        );
        $handler = new LoggerProxyCommandHandler(
            new RetryCommandHandlerDecorator($handler),
            $logger,
            'Try to handle command',
        );

        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch($command);

        $this->assertEquals(1, DummyCommandHandler::$invocations);

        $this->assertTrue(true);

    }
}
