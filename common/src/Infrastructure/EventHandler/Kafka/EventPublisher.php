<?php

namespace Common\Infrastructure\EventHandler\Kafka;

use Common\Application\EventPublisher\Event;
use Common\Application\EventPublisher\Port\EventPublisher as EventPublisherPort;
use RdKafka\Conf;
use RdKafka\Producer;

class EventPublisher implements EventPublisherPort
{
    public function publish(Event $event, callable $success, callable $fail): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $producer = new Producer($conf);

        if ($producer->addBrokers("kafka:9092") < 1) {
            $fail($event);
            echo "Failed adding brokers\n";
            $fail($event);
            return;
        }

        $topic = $producer->newTopic("real-topic");

        if (!$producer->getMetadata(false, $topic, 2000)) {
            echo "Failed to get metadata, is broker down?\n";
            $fail($event);
            return;
        }

        $msg = json_encode([
            'name'     => $event->getEventName(),
            'event_id' => $event->getEventId(),
            'payload'  => $event->getPayload(),
        ]);
        var_dump($msg);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);

        $producer->flush(10000);
        $success($event);

        echo "Message published\n";
    }
}