<?php
declare(strict_types=1);

namespace Denysov\Demo\Application\Event\Ping;

use Denysov\Demo\Domain\Model\Ping\Event\PingCreated;
use Zinc\Core\Event\EventHandlerInterface;
use Zinc\Core\Logging\Logger;

class PingCreatedEventHandler implements EventHandlerInterface
{
    public function __invoke(PingCreated $event)
    {
        Logger::info('####### PROCESSING EVENT #######: ' . $event::class, [
            'id' => $event->getAggregateId()->toString()
        ]);
    }
}