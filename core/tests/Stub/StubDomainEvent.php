<?php
declare(strict_types=1);

namespace Tests\Stub;

use Zinc\Core\Domain\Event\AbstractEvent;
use Zinc\Core\Domain\Event\Event;
use Zinc\Core\Domain\Value\Uuid;

class StubDomainEvent extends AbstractEvent implements Event
{

    public function __construct(Uuid $id)
    {
        $this->aggregateId = $id;
    }

    #[\Override] public function toArray(): array
    {
        return [

        ];
    }
}