<?php

namespace Common\Application\EventHandler;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventHandler\Message\Port\Message;
use Common\Application\EventHandler\Port\EventConsumer as EventConsumerPort;
use Common\Application\Serializer\Event\EventSerializer;
use Psr\Log\LoggerInterface;

abstract class EventConsumer implements EventConsumerPort
{
    public function __construct(
        private EventBus $eventBus,
        private EventSerializer $eventSerializer,
        private LoggerInterface $logger,
    )
    {
    }

    /**
     * @param string $group
     * @param string $topic
     * @return void
     */
    final public function consume(string $group, string $topic): void
    {
        $this->beforeRun($group, $topic);
        while (true) {
            try {
                $message = $this->consumeMessage($group, $topic);
                $event = $this->eventSerializer->deserialize($message->getName(), $message->getPayload());
                $this->eventBus->dispatch($event);

                $this->logger->info('Received an event: ' . $message->getName(), [
                    'id'      => $message->getPayload()['id'],
                    'payload' => $message->getPayload(),
                ]);
            } catch (\Throwable $exception) {
                $this->logger->error('Error handling an event' . $exception->getMessage());
            }
        }
    }

    /**
     * @param $group
     * @param $topic
     * @return void
     */
    protected function beforeRun($group, $topic)
    {
    }

    /**
     * @param string $group
     * @param string $topic
     * @return Message
     */
    abstract protected function consumeMessage(string $group, string $topic): Message;
}