<?php
declare(strict_types=1);

namespace Denysov\Demo\Application\Command\Ping;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Logging\Logger;

class PingCommandHandler implements CommandHandlerInterface
{
    public function __invoke(PingCommand $command)
    {
        Logger::info('PING HANDLER STARTED');
        Logger::info('PING HANDLER FINISHED');
    }

}