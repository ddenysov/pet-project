<?php

namespace Tests\Mock\Domain\Aggregate;

use Common\Domain\Entity\Aggregate;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

class StubBlogPost extends Aggregate
{
    protected StubBlogTitle $title;

    protected StubBlogDescription $description;

    public function getTitle(): StubBlogTitle
    {
        return $this->title;
    }

    public function getDescription(): StubBlogDescription
    {
        return $this->description;
    }

    /**
     * @throws InvalidUuidException
     */
    public static function create(StubBlogId $id, StubBlogTitle $title, StubBlogDescription $description): self
    {
        return (new self($id))->recordThat(new StubBlogPostCreatedEvent(
            title: $title,
            description: $description
        ));
    }

    public function onStubBlogPostCreatedEvent(StubBlogPostCreatedEvent $event): void
    {
        $this->title = $event->getTitle();
        $this->description = $event->getDescription();
    }
}