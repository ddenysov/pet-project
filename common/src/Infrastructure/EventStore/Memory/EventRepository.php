<?php

namespace Common\Infrastructure\EventStore\Memory;

use Common\Domain\Event\EventStream;
use Common\Domain\Event\Port\Event;
use Common\Domain\ValueObject\Uuid;

class EventRepository implements \Common\Application\EventStore\Port\EventRepository
{
    /**
     * Храним события в виде:
     * [
     *    (string)aggregateId => [ Event1, Event2, ... ],
     *    (string)aggregateId2 => [ ... ],
     * ]
     */
    private array $storage = [];

    /**
     * Флаг, что транзакция активна
     */
    private bool $inTransaction = false;

    /**
     * Бэкап состояния на момент начала транзакции
     */
    private array $backupStorage = [];

    /**
     * Сохранение события: добавляем в массив, используя строковое значение aggregateId как ключ.
     */
    public function append(Event $event): void
    {
        $aggregateIdStr = (string)$event->getAggregateId();
        if (!isset($this->storage[$aggregateIdStr])) {
            $this->storage[$aggregateIdStr] = [];
        }
        $this->storage[$aggregateIdStr][] = $event;
    }

    /**
     * Получаем массив событий по конкретному aggregateId
     * и заворачиваем его в EventStream.
     */
    public function stream(Uuid $aggregateId): EventStream
    {
        $aggregateIdStr = (string)$aggregateId;
        $events = $this->storage[$aggregateIdStr] ?? [];
        return new EventStream($events);
    }

    /**
     * Начинаем транзакцию: бэкапим текущее состояние
     */
    public function startTransaction(): void
    {
        $this->inTransaction = true;
        // Делаем глубокую копию массива, чтобы при rollback() всё восстановить
        $this->backupStorage = $this->storage;
    }

    /**
     * Подтверждаем транзакцию: сбрасываем бэкап
     */
    public function commit(): void
    {
        $this->inTransaction = false;
        $this->backupStorage = [];
    }

    /**
     * Откатываемся на состояние при startTransaction()
     */
    public function rollback(): void
    {
        if ($this->inTransaction) {
            $this->storage = $this->backupStorage;
            $this->backupStorage = [];
            $this->inTransaction = false;
        }
    }
}