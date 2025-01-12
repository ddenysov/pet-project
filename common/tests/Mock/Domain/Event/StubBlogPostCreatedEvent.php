<?php

namespace Tests\Mock\Domain\Event;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;


class StubBlogPostCreatedEvent extends Event
{
    protected StubBlogTitle $title;

    protected StubBlogDescription $description;

    /**
     * @param StubBlogTitle $title
     * @param StubBlogDescription $description
     * @throws InvalidUuidException
     */
    public function __construct(StubBlogTitle $title, StubBlogDescription $description)
    {
        parent::__construct();
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