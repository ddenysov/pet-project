<?php

namespace Common\Application\Projector;

use Common\Domain\Event\Port\Event;

abstract class Projector
{
    public function apply(Event $event): void
    {

    }

    //protected function handle(Event $event): void
}