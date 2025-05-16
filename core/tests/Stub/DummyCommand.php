<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Command\Command;

/**
 * Very small command implementation used only in unit–tests.
 */
final class DummyCommand implements Command
{
    public function __construct(
        public readonly string $payload = 'test-payload'
    ) {}

    #[\Override] public function toArray(): array
    {
        return [
            'payload' => $this->payload,
        ];
    }
}
