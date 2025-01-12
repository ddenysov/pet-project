<?php

namespace Tests\Mock\Domain\Repository;

use Common\Domain\Event\Port\EventStream;
use Override;
use Tests\Mock\Domain\Aggregate\StubBlogPost;

class StubBlogPostRepository implements Port\StubBlogPostRepository
{
    #[Override] public function save(StubBlogPost $blogPost): EventStream
    {
        return $blogPost->releaseEvents();
    }
}