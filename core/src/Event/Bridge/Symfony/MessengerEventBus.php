<?php
declare(strict_types=1);

namespace Zinc\Core\Event\Bridge\Symfony;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Zinc\Core\Domain\Event\EventInterface;
use Zinc\Core\Event\EventBusInterface;

class MessengerEventBus implements EventBusInterface
{

    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[\Override] public function dispatch(EventInterface $event): void
    {
        $this->bus->dispatch(
            $event,
            [new TransportNamesStamp(['rr'])]
        );
    }
}