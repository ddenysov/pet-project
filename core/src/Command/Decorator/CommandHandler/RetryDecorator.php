<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;

class RetryDecorator implements CommandHandlerInterface
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
