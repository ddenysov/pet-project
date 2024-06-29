<?php

namespace User\Infrastructure\Schedule\Symfony;

use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use User\Infrastructure\Schedule\Symfony\Outbox\ProcessOutboxMessage;

#[AsSchedule(name: 'default')]
class ScheduleProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('2 seconds', new ProcessOutboxMessage())
        );
    }
}