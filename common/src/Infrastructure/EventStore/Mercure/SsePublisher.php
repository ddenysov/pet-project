<?php

namespace Common\Infrastructure\EventStore\Mercure;

use Common\Application\EventStore\Port\SsePublisher as SsePublisherPort;
use Common\Domain\Event\Port\Event;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class SsePublisher implements SsePublisherPort
{
    public function __construct(private HubInterface $hub)
    {
    }

    /**
     * How to get user ti notify ?
     * How to get aggregate name
     * @param Event $event
     * @return void
     */
    public function publish(Event $event): void
    {
        $update = new Update(
            'https://updates/user/123',
            json_encode([
                'entity'      => 'rides',
                'event'       => $event->getEventName(),
                'aggregateId' => $event->getAggregateId(),
            ])
        );

        $this->hub->publish($update);
    }
}