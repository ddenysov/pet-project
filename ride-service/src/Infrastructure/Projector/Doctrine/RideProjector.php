<?php

namespace Ride\Infrastructure\Projector\Doctrine;

use Common\Domain\ValueObject\StringValue;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Log\LoggerInterface;
use Ride\Domain\Event\RideCreated;
use Ride\Domain\Event\RideEvent;
use Ride\Domain\Event\RideUpdated;
use Ride\Infrastructure\Persistence\Doctrine\Entity\Ride;
use Symfony\Component\Uid\Uuid;

class RideProjector implements \Ride\Application\Projector\Port\RideProjector
{
    private array $eventsMap = [
        RideUpdated::class => 'onRideUpdated',
        RideCreated::class => 'onRideCreated',
    ];

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    )
    {
    }

    public function apply(RideEvent $event): void
    {
        $method = $this->eventsMap[get_class($event)];
        $this->$method($event);
    }

    /**
     * @param RideUpdated $event
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function onRideUpdated(RideUpdated $event): void
    {
        $this->logger->info('Ride updating projection: ' . $event->getAggregateId()->toString());

        $ride = $this->entityManager->find(Ride::class, Uuid::fromString($event->getAggregateId()->toString()));
        $ride->setName($event->getRideName()->toString());
        $this->entityManager->persist($ride);
        $this->entityManager->flush();

        $this->logger->info('Ride updated projection: ' . $event->getAggregateId()->toString());
    }

    /**
     * @param RideCreated $event
     * @return void
     */
    protected function onRideCreated(RideCreated $event): void
    {
        $this->logger->info('Ride creating projection: ' . $event->getAggregateId()->toString());

        $dbEntity = new Ride();
        $dbEntity->setId(Uuid::fromString($event->getAggregateId()->toString()));
        $dbEntity->setName($event->getRideName()->toString());
        $dbEntity->setCreatedAt(new DateTime());
        $dbEntity->setStartDateTime(new DateTime());
        $dbEntity->setEndDateTime(new DateTime());
        $dbEntity->setUserId(Uuid::v4());

        $this->entityManager->persist($dbEntity);
        $this->entityManager->flush();
        $this->logger->info('Ride projection created: ' . $dbEntity->getId()->toString(), $event->payload());
    }
}