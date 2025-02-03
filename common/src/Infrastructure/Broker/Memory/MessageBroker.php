<?php

namespace Common\Infrastructure\Broker\Memory;

use Common\Application\Broker\Port\MessageBroker as MessageBrokerPort;
use Common\Application\Broker\Port\Message;
use Common\Application\Broker\Port\MessageChannel;

/**
 * Stub-класс для работы с брокером сообщений в памяти.
 * Используется для упрощённого тестирования.
 */
class MessageBroker implements MessageBrokerPort
{
    /**
     * Хранение сообщений в очередях по каналам.
     *
     * @var array<string, Message[]>
     */
    private array $queues = [];

    /**
     * Публикация сообщения в очередь.
     *
     * @param Message $message
     * @return void
     */
    public function publish(Message $message): void
    {
        // Предполагаем, что объект Message имеет метод getChannel(), который возвращает MessageChannel
        $channel = $message->getChannel();
        $channelKey = md5($channel->getName());

        if (!isset($this->queues[$channelKey])) {
            $this->queues[$channelKey] = [];
        }
        $this->queues[$channelKey][] = $message;
    }

    /**
     * Извлечение сообщения из указанного канала.
     *
     * @param MessageChannel $channel
     * @return Message
     *
     * @throws \RuntimeException Если в очереди канала нет сообщений.
     */
    public function consume(MessageChannel $channel): Message
    {
        $channelKey = md5($channel->getName());

        if (empty($this->queues[$channelKey])) {
            throw new \RuntimeException('В канале отсутствуют сообщения для обработки.');
        }

        // Возвращаем и удаляем первое сообщение из очереди
        return array_shift($this->queues[$channelKey]);
    }
}
