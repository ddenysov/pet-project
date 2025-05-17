<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Command\AbstractCommandHandler;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Value\Uuid;

/**
 * Dummy handler that records calls for assertions.
 *
 * @implements CommandHandler<DummyCommand>
 */
final class DummyCommandHandler extends AbstractCommandHandler implements CommandHandler
{
    /** Number of times the handler was invoked. */
    public static int $invocations = 0;

    /** Last command instance passed to the handler. */
    public ?Command $lastCommand = null;

    public function __invoke(Command|DummyCommand $command): EventStream
    {
        ++self::$invocations;
        $this->lastCommand = $command;

        $root = StubAggregate::create(Uuid::fromString($command->id));

        return $this->persist($root);
    }
}