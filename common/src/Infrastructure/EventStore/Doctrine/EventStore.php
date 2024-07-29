<?php

namespace Common\Infrastructure\EventStore\Doctrine;

use Common\Application\EventStore\Port\EventStore as EventStorePort;
use Common\Domain\Event\Port\EventCollection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class EventStore implements EventStorePort
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function append(EventCollection $events): EventStorePort
    {
        $this->entityManager->beginTransaction();
        try {
            foreach ($events as $event) {
                $this->entityManager->getConnection()
                    ->createQueryBuilder()
                    ->insert('event_store')
                    ->values([
                        'aggregate_id' => $event->getAggrefateId(),
                        'payload'      => $event->getPayload(),
                    ])->setParameter(0, $event->getAggrefateId())
                    ->setParameter(0, $event->getPayload())
                    ->executeQuery()
                ;
            }
        } catch (Throwable $exception) {
            $this->entityManager->rollback();
            throw $exception;
        }
        $this->entityManager->commit();
    }
}