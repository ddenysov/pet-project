<?php
declare(strict_types=1);

namespace Zinc\Core\Command;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Root\Aggregate;
use Zinc\Core\Event\EventBus;
use Zinc\Core\Event\Repository\EventStoreRepository;
use Zinc\Core\Message\Outbox\Outbox;

abstract class AbstractCommandHandler implements CommandHandler
{
    public function __construct(
        private EventStoreRepository $repository,
        private Outbox $outbox,
        private EventBus $eventBus,
    ) {
    }

    protected function persist(Aggregate $aggregate): EventStream
    {
        $events = $this->repository->getDataStore()->transactional(function () use ($aggregate) {
            $events = $this->repository->save($aggregate);
            $this->outbox->saveStream($events);

            return $events;
        });
        $this->eventBus->dispatchMany($events);

        return $events;
    }
}