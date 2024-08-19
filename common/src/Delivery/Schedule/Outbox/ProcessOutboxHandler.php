<?php

namespace Common\Delivery\Schedule\Outbox;

use Common\Application\Outbox\Port\Outbox;

readonly class ProcessOutboxHandler
{
    public function __construct(private Outbox $outbox)
    {
    }

    public function __invoke(ProcessOutboxMessage $message)
    {
        $this->outbox->publish();
    }
}