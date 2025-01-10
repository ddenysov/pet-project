<?php
declare(strict_types=1);

namespace Tests\Domain\Aggregate;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogPost;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogId;

final class AggregateTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     */
    public function testCase1(): void
    {
        $blogPost = StubBlogPost::create(StubBlogId::create());
        $events = $blogPost->releaseEvents();

        dd($events);

        $this->assertTrue(true);
    }
}