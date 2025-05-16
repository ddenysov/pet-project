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
use Zinc\Core\Command\Middleware\TransactionalMiddleware;
use Zinc\Core\Command\Proxy\CommandHandler\LoggerProxy;
use Zinc\Core\DataStore\Bridge\InMemory\InMemoryDataStore;
use Zinc\Core\Logging\Bridge\Print\PrintLogger;

class CommandHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testName()
    {
        $command = new DummyCommand();
        $logger = new PrintLogger();
        $mockDataStore = $this->createMock(InMemoryDataStore::class);

        // Expect the transactional method to be called exactly once
        $mockDataStore
            ->expects($this->once())
            ->method('transactional')
            ->willReturnCallback(function (callable $fn) {
                return $fn(); // Call the actual handler inside the transaction
            });

        $handler = new MiddlewareCommandHandlerDecorator(
            new LoggerProxy(new DummyCommandHandler(), $logger, 'Handle Dummy Command'),
            new MiddlewareResultLoggingProxy(new TransactionalMiddleware(
                $mockDataStore,
                new MiddlewareResultLoggingProxy(new EventStoreMiddleware(), $logger, 'Saving to event store'),
                new MiddlewareResultLoggingProxy(new OutboxMiddleware(), $logger, 'Saving to outbox'),
            ), $logger, 'Transaction Middleware'),
            new MiddlewareResultLoggingProxy(new EventBusMiddleware(), $logger, 'Publishing to Event Bus'),

        );
        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch($command);

        $this->assertEquals(1, DummyCommandHandler::$invocations);

        $this->assertTrue(true);

    }
}
