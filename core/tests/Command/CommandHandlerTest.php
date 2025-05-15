<?php


namespace Tests\Command;

use PHPUnit\Framework\TestCase;
use Tests\Stub\DummyCommand;
use Tests\Stub\DummyCommandHandler;
use Zinc\Core\Command\Bridge\InMemory\InMemoryCommandBus;
use Zinc\Core\Command\Decorator\TransactionalCommandHandlerDecorator;
use Zinc\Core\DataStore\Bridge\InMemory\InMemoryDataStore;

class CommandHandlerTest extends TestCase
{
    public function testName()
    {
        $command = new DummyCommand();
        $handler = new TransactionalCommandHandlerDecorator(new DummyCommandHandler(), new InMemoryDataStore());
        $bus = new InMemoryCommandBus();
        $bus->register(DummyCommand::class, $handler);
        $bus->dispatch(new DummyCommand());

        $this->assertEquals(1, DummyCommandHandler::$invocations);

        $this->assertTrue(true);

    }
}
