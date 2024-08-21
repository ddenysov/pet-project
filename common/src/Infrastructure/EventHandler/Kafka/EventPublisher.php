<?php

namespace Common\Infrastructure\EventHandler\Kafka;

use Common\Application\EventHandler\Event;
use Common\Application\EventHandler\Port\EventPublisher as EventPublisherPort;
use RdKafka\Conf;
use RdKafka\Producer;
use Exception;

class EventPublisher extends \Common\Application\EventHandler\EventPublisher implements EventPublisherPort
{
    /**
     * @param Event $event
     * @return void
     * @throws Exception
     */
    protected function dispatch(Event $event, string $channel): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $producer = new Producer($conf);

        if ($producer->addBrokers("kafka:9092") < 1) {
            throw new Exception('Failed to add Kafka broker');
        }

        $topic = $producer->newTopic($channel);

        if (!$producer->getMetadata(false, $topic, 2000)) {
            throw new Exception('Failed to get metadata, is broker down?');
        }

        $msg = json_encode([
            'name'     => $event->getEventName(),
            'event_id' => $event->getEventId(),
            'payload'  => $event->getPayload(),
        ]);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);
        $producer->flush(10000);
    }
}