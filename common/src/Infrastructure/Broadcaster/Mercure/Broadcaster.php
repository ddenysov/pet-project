<?php

namespace Common\Infrastructure\Broadcaster\Mercure;

use Common\Application\Broadcaster\Port\Broadcaster as BroadcasterPort;
use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Uuid;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class Broadcaster implements BroadcasterPort
{
    public function __construct(private HubInterface $hub)
    {
    }

    /**
     * @param Uuid $identity
     * @param Event $event
     * @return void
     */
    public function broadcastMessageTo(Uuid $identity, Event $event,): void
    {
        $update = new Update(
            'https://updates/user/' . $identity->toString(),
            json_encode([
                'name' => $event->getEventName(),
                'payload' => $event->payload(),
            ])
        );

        $this->hub->publish($update);
    }

    /**
     * @param Event $event
     * @return void
     */
    public function broadcastMessage(Event $event,): void
    {
        $update = new Update(
            'https://updates/all',
            json_encode($event->payload())
        );

    }

}