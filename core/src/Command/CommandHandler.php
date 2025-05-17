<?php
declare(strict_types=1);

namespace Zinc\Core\Command;

use Zinc\Core\Domain\Event\EventStream;

/**
 * Handles a single Command instance.
 *
 * @template C of Command
 */
interface CommandHandler
{
    /**
     * @param Command $command
     * @return EventStream
     */
    public function __invoke(Command $command): EventStream;
}
