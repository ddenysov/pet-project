<?php


namespace Tests\Command;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Stub\DummyCommand;
use Tests\Stub\DummyCommandHandler;
use Zinc\Core\Command\Bridge\InMemory\InMemoryCommandBus;
use Zinc\Core\Command\Decorator\CommandHandler\TransactionalDecorator;
use Zinc\Core\Command\Middleware\Decorator\MiddlewareCommandHandlerDecorator;
use Zinc\Core\Command\Middleware\EventBusMiddleware;
use Zinc\Core\Command\Middleware\EventStoreMiddleware;
use Zinc\Core\Command\Middleware\OutboxMiddleware;
use Zinc\Core\Command\Middleware\Proxy\MiddlewareResultLoggingProxy;
use Zinc\Core\Command\Middleware\Proxy\MiddlewareStartLoggingProxy;
use Zinc\Core\Command\Middleware\RetryMiddleware;
use Zinc\Core\Command\Middleware\TransactionalMiddleware;
use Zinc\Core\Command\Proxy\CommandHandler\LoggerProxy;
use Zinc\Core\DataStore\Bridge\InMemory\InMemoryDataStore;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\Bridge\InMemory\InMemoryEventBus;
use Zinc\Core\Event\EventStore;
use Zinc\Core\Event\Repository\EventStoreRepository;
use Zinc\Core\Logging\Bridge\Print\PrintLogger;
use Zinc\Core\Message\Outbox\Outbox;

class CommandHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testName()
    {


        $command = new DummyCommand(Uuid::create()->toString());
        $logger = new PrintLogger();
        $mockDataStore = $this->createMock(InMemoryDataStore::class);

        // Expect the transactional method to be called exactly once
        $mockDataStore
            ->expects($this->once())
            ->method('transactional')
            ->willReturnCallback(function (callable $fn) {
                return $fn(); // Call the actual handler inside the transaction
            });

        $eventStore = new EventStore($mockDataStore);
        $repository = new EventStoreRepository($eventStore);
        $outbox = new Outbox($mockDataStore);
        $eventBus = new InMemoryEventBus();

        $handler = new DummyCommandHandler(
            $repository,
            $outbox,
            $eventBus,
        );

        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch($command);

        $this->assertEquals(1, DummyCommandHandler::$invocations);

        $this->assertTrue(true);

    }
}
