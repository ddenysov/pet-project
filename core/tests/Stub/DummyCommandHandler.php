<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Command\Command;
use Zinc\Core\Command\CommandHandler;

/**
 * Dummy handler that records calls for assertions.
 *
 * @implements CommandHandler<DummyCommand>
 */
final class DummyCommandHandler implements CommandHandler
{
    /** Number of times the handler was invoked. */
    public static int $invocations = 0;

    /** Last command instance passed to the handler. */
    public ?Command $lastCommand = null;

    public function __invoke(Command $command): mixed
    {
        ++self::$invocations;
        $this->lastCommand = $command;

        // Return any value you might want to assert on.
        return 'handled';
    }
}