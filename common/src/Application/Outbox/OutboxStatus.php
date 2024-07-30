<?php

namespace Common\Application\Outbox;

enum OutboxStatus: string
{
    case STARTED = 'STARTED';
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';
}
