<?php

namespace Tests\Domain\Aggregate\Stub\Aggregate;

use Common\Domain\Entity\Aggregate;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogId;
use Tests\Domain\Aggregate\Stub\Event\StubBlogPostCreatedEvent;

class StubBlogPost extends Aggregate
{
    public static function create(StubBlogId $id): self
    {
        return (new self($id))->recordThat(new StubBlogPostCreatedEvent());
    }

    public function onStubBlogPostCreatedEvent(StubBlogPostCreatedEvent $event)
    {

    }
}