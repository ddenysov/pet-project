<?php

namespace Common\Infrastructure\Broker\Memory;

use Common\Application\Broker\MessageCollection as MessageCollectionImpl;
use Common\Application\Broker\Port\Message;
use Common\Application\Broker\Port\MessageCollection;
use RuntimeException;

class MessageOutboxRepository implements \Common\Application\Broker\Port\MessageOutboxRepository
{
    /**
     * @var Message[]
     */
    private array $messages = [];

    /**
     * Флаг, указывающий, что транзакция активна
     *
     * @var bool
     */
    private bool $inTransaction = false;

    /**
     * Сюда сохраняется копия сообщений на момент начала транзакции
     * (для возможности отката).
     *
     * @var Message[]
     */
    private array $backupMessages = [];

    /**
     * Признак фильтра по статусу pending.
     *
     * @var bool
     */
    private bool $filterPending = false;

    /**
     * Сохранение сообщения в локальный массив.
     */
    public function save(Message $message): void
    {
        $this->messages[$message->getId()] = $message;
    }

    #[\Override] public function complete(Message $message): void
    {
        $message->complete();
        $this->save($message);
    }

    /**
     * Получение коллекции сообщений.
     * Если установлен фильтр по pending — возвращаем только такие.
     * Иначе — все сообщения.
     */
    public function get(): MessageCollection
    {
        if ($this->filterPending) {
            $this->filterPending = false; // сбрасываем флаг, чтобы при следующем get() вернулись все сообщения
            $filtered = array_filter($this->messages, fn($msg) => $msg->getStatus() === 'pending');
            return new MessageCollectionImpl(array_values($filtered));
        }

        return new MessageCollectionImpl(array_map(function($value) { return $value; }, $this->messages));
    }

    /**
     * Поиск одного сообщения по ID.
     * Если нет в массиве — можно выбрасывать исключение или вернуть что-то по умолчанию.
     */
    public function find(string $id): Message
    {
        if (!isset($this->messages[$id])) {
            throw new RuntimeException("Message with ID {$id} not found");
        }

        return $this->messages[$id];
    }

    /**
     * Активируем флаг фильтра по статусу pending (будет учтён в методе get()).
     */
    public function pending(): self
    {
        $this->filterPending = true;
        return $this;
    }

    /**
     * Начало транзакции:
     * сохраняем текущее состояние массива сообщений в backupMessages.
     */
    public function startTransaction(): void
    {
        $this->inTransaction = true;
        $this->backupMessages = $this->messages;
    }

    /**
     * Коммит:
     * просто сбрасываем бэкап, так как изменения подтверждены.
     */
    public function commit(): void
    {
        $this->inTransaction = false;
        $this->backupMessages = [];
    }

    /**
     * Ролбэк:
     * восстанавливаем массив сообщений из бэкапа.
     */
    public function rollback(): void
    {
        if ($this->inTransaction) {
            $this->messages = $this->backupMessages;
            $this->backupMessages = [];
            $this->inTransaction = false;
        }
    }

    #[\Override] public function limit(int $number): static
    {
        return $this;
    }

    #[\Override] public function offset(int $number): static
    {
        return $this;
    }

}