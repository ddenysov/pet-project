<?php

declare(strict_types=1);

namespace Zinc\Core\Repository\Proxy;

use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Repository\Repository;
use Zinc\Core\Domain\Aggregate\Aggregate;
use Zinc\Core\Logging\LogManager;

class LoggingRepositoryProxy implements Repository
{
    public function __construct(
        private readonly Repository $inner,
        private readonly LogManager $logger,
        private readonly ?string $message = null,
    ) {}

    #[\Override]
    public function save(Aggregate $aggregate): EventStream
    {
        return $this->logger->log(
            fn() => $this->inner->save($aggregate),
            $this->message ?? 'Saving aggregate to repository',
            [
                'aggregate' => $aggregate->toArray(),
            ],
        );
    }
}
