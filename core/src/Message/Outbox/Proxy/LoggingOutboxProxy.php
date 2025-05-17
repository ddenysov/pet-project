<?php
declare(strict_types=1);

namespace Zinc\Core\Message\Outbox\Proxy;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Logging\LogManager;
use Zinc\Core\Message\Outbox\Outbox;

class LoggingOutboxProxy extends Outbox
{
    public function __construct(
        private readonly Outbox $inner,
        private readonly LogManager $logger,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function saveStream(EventStream $stream)
    {
        return $this->logger->log(
            fn() => $this->inner->saveStream($stream),
            'Saving stream to outbox',
        );
    }
}