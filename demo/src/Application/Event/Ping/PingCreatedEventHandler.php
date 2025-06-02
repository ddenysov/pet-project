<?php
declare(strict_types=1);

namespace Denysov\Demo\Application\Event\Ping;

use Denysov\Demo\Domain\Model\Ping\Event\PingCreated;
use Zinc\Core\DataStore\DataStore;
use Zinc\Core\DataStore\DataStoreInterface;
use Zinc\Core\Event\EventHandlerInterface;
use Zinc\Core\Logging\Logger;

class PingCreatedEventHandler implements EventHandlerInterface
{

    public function __construct(private DataStoreInterface $store)
    {
    }

    public function __invoke(PingCreated $event)
    {
        $this->store->insert('ping', [
            'id' => $event->getAggregateId()->toString()
        ]);
        $res = $this->store->find('ping');
        Logger::info('####### PROCESSING EVENT #######: ' . $event::class, [
            'id' => $event->getAggregateId()->toString(),
            'res' => $res,
        ]);
    }
}