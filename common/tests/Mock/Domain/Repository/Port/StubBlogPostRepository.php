<?php

namespace Tests\Mock\Domain\Repository\Port;

use Common\Domain\Event\Port\EventStream;
use Tests\Mock\Domain\Aggregate\StubBlogPost;

interface StubBlogPostRepository
{
    public function save(StubBlogPost $blogPost): EventStream;
}