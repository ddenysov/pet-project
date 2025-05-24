<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator;

use Aws\CommandInterface;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Command\CommandHandlerInterface;

/**
 * Decorator that retries an inner CommandHandler up to N times,
 * increasing the delay before each next attempt (linear-backoff by default).
 *
 * @template C of CommandInterface
 * @implements CommandHandlerInterface<C>
 */
final readonly class RetryCommandHandlerDecorator implements CommandHandler
{
    /**
     * @param CommandHandlerInterface<C> $inner
     * @param int               $maxAttempts
     * @param int               $initialDelayMs
     * @param int               $stepMs
     */
    public function __construct(
        private readonly CommandHandlerInterface $inner,
        private readonly int $maxAttempts = 3,
        private readonly int $initialDelayMs = 100,
        private readonly int $stepMs = 100,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(CommandInterface $command): void
    {
        $attempt = 0;
        $delay   = $this->initialDelayMs;

        while (true) {
            try {
                ($this->inner)($command);

                return;
            } catch (\Throwable $e) {
                $attempt++;

                if ($attempt >= $this->maxAttempts) {
                    throw $e;
                }

                \usleep($delay * 1000);
                $delay += $this->stepMs;
            }
        }
    }
}
