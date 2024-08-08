<?php

namespace Iam\Delivery\Schedule\Outbox;

use Common\Application\Outbox\Port\Outbox;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use User\Application\Outbox\OutboxRepository;

#[AsMessageHandler]
readonly class ProcessOutboxHandler
{

    public function __construct(private Outbox $outbox)
    {
    }

    public function __invoke(ProcessOutboxMessage $message)
    {
        dump($message);
        $this->outbox->publish();
    }
}