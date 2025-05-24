<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Bridge\InMemory;

use Zinc\Core\Command\CommandBusInterface;
use Zinc\Core\Command\CommandInterface;

/**
 * Simple in-memory implementation of the CommandBus.
 * Stores a map “command-class → handler” inside the object itself,
 * without involving any external service container.
 *
 * A handler can be:
 *  – an invokable object implementing __invoke(Command): mixed
 *  – a callable (e.g. static function, closure, [$object, 'method'])
 */
final class InMemoryCommandBus implements CommandBusInterface
{
    /** @var array<class-string<CommandInterface>, callable(CommandInterface):mixed> */
    private array $handlers = [];

    /**
     * @param array<class-string<CommandInterface>, callable(CommandInterface):mixed> $handlers
     */
    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
    }

    /**
     * Registers (or replaces) a handler at runtime.
     *
     * @param class-string<CommandInterface> $commandClass
     * @param callable(CommandInterface):mixed $handler
     */
    public function register(string $commandClass, callable $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    #[\Override]
    public function dispatch(CommandInterface $command): mixed
    {
        $commandClass = $command::class;

        if (!isset($this->handlers[$commandClass])) {
            throw new \RuntimeException(
                \sprintf('No handler registered for command "%s".', $commandClass),
            );
        }

        return ($this->handlers[$commandClass])($command);
    }
}
