<?php

namespace Tests\Mock\Application\Command;

class StubCreateBlogPostCommand
{
    public string $title;

    public string $description;

    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(string $title, string $description)
    {
        $this->title       = $title;
        $this->description = $description;
    }
}