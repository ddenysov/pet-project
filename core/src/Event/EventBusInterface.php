<?php

declare(strict_types=1);

namespace Zinc\Core\Event;

use Zinc\Core\Domain\Event\EventInterface;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
