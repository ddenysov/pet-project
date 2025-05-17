<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Decorator;

use Throwable;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Domain\Event\EventStream;

/**
 * Decorator that retries an inner CommandHandler up to N times,
 * increasing the delay before each next attempt (linear-backoff by default).
 *
 * @template C of Command
 * @implements CommandHandler<C>
 */
final readonly class RetryCommandHandlerDecorator implements CommandHandler
{
    /**
     * @param CommandHandler<C> $inner
     * @param int               $maxAttempts   How many times to try in total (1 ⇒ no retry).
     * @param int               $initialDelayMs Delay before 1-й повтор (миллисекунды).
     * @param int               $stepMs        How much to add к задержке на каждый next retry.
     *                                          (Для экспоненциальной схемы поменяйте логику внутри цикла.)
     */
    public function __construct(
        private readonly CommandHandler $inner,
        private readonly int $maxAttempts = 3,
        private readonly int $initialDelayMs = 100,
        private readonly int $stepMs = 100,
    ) {
    }

    /**
     * @param Command $command
     * @return void
     * @throws Throwable
     */
    public function __invoke(Command $command): void
    {
        $attempt = 0;
        $delay   = $this->initialDelayMs;

        while (true) {
            try {
                ($this->inner)($command);

                return;
            } catch (Throwable $e) {
                $attempt++;

                if ($attempt >= $this->maxAttempts) {
                    throw $e;
                }

                usleep($delay * 1000);
                $delay += $this->stepMs;
            }
        }
    }
}
