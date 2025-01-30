<?php

namespace Tests\Mock\Application\Command;

class StubCreateBlogPostCommand
{
    public string $id;
    public string $title;
    public string $description;

    /**
     * @param string $id
     * @param string $title
     * @param string $description
     */
    public function __construct(string $id, string $title, string $description)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
    }
}