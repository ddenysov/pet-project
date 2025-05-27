<?php
declare(strict_types=1);

namespace Zinc\Core\Event\Bridge\Symfony;

use Symfony\Component\Messenger\MessageBusInterface;
use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Event\EventBus;

class MessengerEventBus implements EventBus
{

    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[\Override] public function dispatch(Event $event): void
    {
        // TODO: Implement dispatch() method.
    }
}