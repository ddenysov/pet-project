<?php

namespace Tests\Domain\Event\Stub;

use Common\Domain\Event\Event;
use Common\Domain\ValueObject\StringValue;
use Common\Domain\ValueObject\TextValue;

class BlogCreatedEvent extends Event
{

    public function __construct(
        protected StringValue $title,
        protected TextValue $description,
    )
    {
        parent::__construct();
    }

    public function getTitle(): StringValue
    {
        return $this->title;
    }

    public function getDescription(): TextValue
    {
        return $this->description;
    }
}