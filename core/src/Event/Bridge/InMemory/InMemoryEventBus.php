<?php

declare(strict_types=1);

namespace Zinc\Core\Event\Bridge\InMemory;

use Zinc\Core\Command\Command;
use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Event\EventBus;

/**
 * Simple in-memory implementation of the CommandBus.
 * Stores a map “command-class → handler” inside the object itself,
 * without involving any external service container.
 *
 * A handler can be:
 *  – an invokable object implementing __invoke(Command): mixed
 *  – a callable (e.g. static function, closure, [$object, 'method'])
 */
final class InMemoryEventBus implements EventBus
{
    /** @var array<class-string<Command>, callable(Command):mixed> */
    private array $handlers = [];

    /**
     * @param array<class-string<Command>, callable(Command):mixed> $handlers
     */
    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
    }

    /**
     * Registers (or replaces) a handler at runtime.
     *
     * @param class-string<Command> $commandClass
     * @param callable(Command):mixed $handler
     */
    public function register(string $commandClass, callable $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    #[\Override]
    public function dispatch(Event $event): void
    {
        $eventClass = $event::class;

        if (!isset($this->handlers[$eventClass])) {
            return;
        }

        $this->handlers[$eventClass]($event);
    }

    #[\Override]
    public function dispatchMany(EventStream $stream): void
    {
        foreach ($stream as $event) {
            $this->dispatch($event);
        }
    }
}
