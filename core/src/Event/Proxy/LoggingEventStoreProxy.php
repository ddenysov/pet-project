<?php
declare(strict_types=1);

namespace Zinc\Core\Event\Proxy;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Event\EventStore;
use Zinc\Core\Logging\LogManager;

class LoggingEventStoreProxy extends EventStore
{
    public function __construct(
        private readonly EventStore $inner,
        private readonly LogManager $logger,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function append(EventStream $stream)
    {
        return $this->logger->log(
            fn() => $this->inner->append($stream),
            'Saving stream to Event Store',
        );
    }

    #[\Override] public function getStreamRevision(Uuid $streamId): int
    {
        return $this->inner->getStreamRevision($streamId);
    }
}