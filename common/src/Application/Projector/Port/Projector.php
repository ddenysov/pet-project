<?php

namespace Common\Application\Projector\Port;

use Common\Domain\Event\Port\Event;

interface Projector
{
    public function apply(Event $event): void;
}