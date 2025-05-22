<?php

declare(strict_types=1);

namespace Zinc\Core\Event;

use Zinc\Core\DataStore\Criteria;
use Zinc\Core\DataStore\DataStore;
use Zinc\Core\DataStore\QueryOptions;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Value\Uuid;

class EventStore
{
    public function __construct(
        private DataStore $dataStore,
    ) {}

    public function append(EventStream $stream): void
    {
        foreach ($stream as $event) {

        }
    }

    public function getStreamRevision(Uuid $streamId): int
    {
        $record = $this->dataStore->findOne(
            'events',
            new Criteria('stream_id', Criteria::OP_EQ, $streamId->toString()),
            new QueryOptions([['revision' => 'DESC']]),
        );

        return $record['revision'] ?? 0;
    }
}
