<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Logging\Logger;

/**
 * Dummy handler that records calls for assertions.
 *
 */
final class DummyCommandHandler implements CommandHandlerInterface
{
    /** Number of times the handler was invoked. */
    public static int $invocations = 0;

    /** Last command instance passed to the handler. */
    public ?CommandInterface $lastCommand = null;

    public function __invoke(DummyCommand $command): EventStream
    {
        Logger::info('Start processing Dummy command');

        ++self::$invocations;
        $this->lastCommand = $command;
        $root = StubAggregate::create(Uuid::fromString($command->id));

        Logger::info('Finishing processing Dummy command');

        return $root->releaseEvents();
    }
}