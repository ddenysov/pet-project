<?php

declare(strict_types=1);

namespace Zinc\Core\Event;

use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Event\EventStream;

interface EventBus
{
    public function dispatch(Event $event): void;
}
