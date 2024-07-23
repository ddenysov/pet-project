<?php

namespace Common\Application\Outbox;

use Common\Domain\Event\Event;

class Outbox
{
    public function __construct()
    {
    }

    public function process(Event $event): void
    {

    }
}