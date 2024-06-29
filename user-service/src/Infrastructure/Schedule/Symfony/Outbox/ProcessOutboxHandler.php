<?php

namespace User\Infrastructure\Schedule\Symfony\Outbox;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use User\Application\Outbox\OutboxRepository;

#[AsMessageHandler]
readonly class ProcessOutboxHandler
{

    public function __construct(
        private readonly OutboxRepository $outboxRepository
    )
    {
    }

    public function __invoke(ProcessOutboxMessage $message)
    {
        $results = $this->outboxRepository->all();
        dump($results[0]);
        // ... do some work to send the report to the customers
    }
}