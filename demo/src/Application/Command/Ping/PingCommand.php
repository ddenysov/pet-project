<?php
declare(strict_types=1);

namespace Denysov\Demo\Application\Command\Ping;

use Override;
use Zinc\Core\Command\CommandInterface;

class PingCommand implements CommandInterface
{
    #[Override] public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}