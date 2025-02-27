<?php

namespace Tests\Mock\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;


class StubBlogPostCreatedEvent extends Event
{
    protected StubBlogTitle $title;

    protected StubBlogDescription $description;

    /**
     * @param StubBlogId|null $id
     * @param StubBlogTitle|null $title
     * @param StubBlogDescription|null $description
     * @throws InvalidUuidException
     */
    public function __construct(
        StubBlogId $id = null,
        StubBlogTitle $title = null,
        StubBlogDescription $description = null
    )
    {
        parent::__construct();
        $this->aggregateId = $id ?? StubBlogId::create();
        $this->title       = $title;
        $this->description = $description;
    }

    public function getTitle(): StubBlogTitle
    {
        return $this->title;
    }

    public function getDescription(): StubBlogDescription
    {
        return $this->description;
    }
}