<?php

namespace Common\Application\EventHandler;

use Common\Application\Bus\Port\EventBus;
use Common\Application\EventHandler\Message\Port\Message;
use Common\Application\EventHandler\Port\EventConsumer as EventConsumerPort;
use Common\Application\Serializer\Event\EventSerializer;
use Psr\Log\LoggerInterface;

abstract class EventConsumer implements EventConsumerPort
{
    /**
     * @var array
     */
    protected array $channelMap;

    /**
     * @param EventBus $eventBus
     * @param EventSerializer $eventSerializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        private EventBus $eventBus,
        private EventSerializer $eventSerializer,
        private LoggerInterface $logger,
    )
    {
    }

    public function configureChannelMap(array $map): void
    {
        foreach ($map as $channel => $events) {
            foreach ($events as $event) {
                $this->channelMap[$event] = $channel;
            }
        }
    }

    /**
     * @param string $group
     * @param string $topic
     * @return void
     */
    final public function consume(string $group, string $topic): void
    {
        $this->beforeRun($group, $topic);

        $this->logger->info('Consumer started. ', [
            'topic' => $topic,
        ]);

        while (true) {
            try {
                $message = $this->consumeMessage($group, $topic);
                $this->logger->info('Received message: ' . $message->getName());

                if (!in_array($message->getName(), [
                    'event.empty',
                    'event.timeout',
                ])) {
                    $this->logger->info('Received message: ' . $message->getName(), [
                        'id'      => $message->getPayload()['eventId'],
                        'payload' => $message->getPayload(),
                    ]);

                    $event = $this->eventSerializer->deserialize($message->getName(), $message->getPayload());
                    $this->eventBus->dispatch($event);
                }
            } catch (\Throwable $exception) {
                $this->logger->error('Error handling an event' . $exception->getMessage(), [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                ]);
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