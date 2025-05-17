<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Persistence;

use Zinc\Core\DataStore\DataStore;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Repository\Repository;
use Zinc\Core\Domain\Root\Aggregate;
use Zinc\Core\Event\EventBus;
use Zinc\Core\Message\Outbox\Outbox;

class AggregatePersistenceManager
{
    public function __construct(
        private Repository $repository,
        private Outbox $outbox,
        private EventBus $eventBus,
        private DataStore $store,
    ) {
    }

    public function persist(Aggregate $aggregate): EventStream
    {
        $events = $this->store->transactional(function () use ($aggregate) {
            $events = $this->repository->save($aggregate);
            $this->outbox->saveStream($events);

            return $events;
        });
        $this->eventBus->dispatchMany($events);

        return $events;
    }
}