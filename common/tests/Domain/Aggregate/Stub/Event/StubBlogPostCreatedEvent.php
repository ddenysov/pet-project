<?php

namespace Tests\Domain\Aggregate\Stub\Event;

use Common\Domain\Event\Event;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogDescription;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogTitle;

class StubBlogPostCreatedEvent extends Event
{
    protected StubBlogTitle $title;

    protected StubBlogDescription $description;

    /**
     * @param StubBlogTitle $title
     * @param StubBlogDescription $description
     */
    public function __construct(StubBlogTitle $title, StubBlogDescription $description)
    {
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