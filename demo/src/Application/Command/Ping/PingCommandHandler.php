<?php
declare(strict_types=1);

namespace Denysov\Demo\Application\Command\Ping;

use Denysov\Demo\Domain\Model\Ping\Ping;
use Denysov\Demo\Domain\Model\Ping\PingId;
use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Logging\Logger;

class PingCommandHandler implements CommandHandlerInterface
{
    public function __invoke(PingCommand $command)
    {
        Logger::info('PING HANDLER STARTED');
        $ping = Ping::create(PingId::create());
        $events = $ping->releaseEvents();
        Logger::info('PING HANDLER FINISHED', [
            'pingId' => $ping->getId()->toString(),
            'events' => (array) $events,
        ]);

        return $events;
    }

}