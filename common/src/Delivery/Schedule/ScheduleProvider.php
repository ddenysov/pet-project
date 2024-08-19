<?php

namespace Common\Delivery\Schedule;

use Common\Delivery\Schedule\Outbox\ProcessOutboxMessage;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

class ScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('2 seconds', new ProcessOutboxMessage())
        );
    }
}