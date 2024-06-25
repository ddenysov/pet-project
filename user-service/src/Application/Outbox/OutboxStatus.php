<?php

namespace User\Application\Outbox;

enum OutboxStatus: string
{
    case STARTED = 'STARTED';
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';
}