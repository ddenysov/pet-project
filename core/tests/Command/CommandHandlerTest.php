<?php


namespace Tests\Command;

use PHPUnit\Framework\TestCase;
use Tests\Stub\DummyCommand;
use Tests\Stub\DummyCommandHandler;
use Zinc\Core\Command\Bridge\InMemory\InMemoryCommandBus;
use Zinc\Core\Command\Decorator\EventBusDecorator;
use Zinc\Core\Command\Decorator\EventStoreDecorator;
use Zinc\Core\Command\Decorator\RetryDecorator;
use Zinc\Core\Command\Middleware\EventBusMiddleware;
use Zinc\Core\Command\Middleware\EventStoreMiddleware;
use Zinc\Core\Command\Middleware\RetryMiddleware;
use Zinc\Core\Domain\Value\Uuid;

class CommandHandlerTest extends TestCase
{
    public function SimpleCommand()
    {
        $command       = new DummyCommand(Uuid::create()->toString());

        $handler = new DummyCommandHandler();

        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch($command);
        $this->assertEquals(1, DummyCommandHandler::$invocations);
        $this->assertTrue(true);
    }

    public function testSimpleCommandSaveToEventStore()
    {
        $command       = new DummyCommand(Uuid::create()->toString());

        $handler = new DummyCommandHandler();
        $handler = new EventStoreDecorator($handler);
        $handler = new RetryDecorator($handler);
        $handler = new EventBusDecorator($handler);

        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch($command);
        $this->assertTrue(true);
    }

    /**
    public function testSimpleCommand()
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
     **/
}
