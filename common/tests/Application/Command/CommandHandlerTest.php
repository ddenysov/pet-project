<?php
declare(strict_types=1);

namespace Tests\Application\Command;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\TestCase;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogDescription;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogPost;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogId;
use Tests\Domain\Aggregate\Stub\Aggregate\StubBlogTitle;
use Tests\Domain\Aggregate\Stub\Event\StubBlogPostCreatedEvent;

final class CommandHandlerTest extends TestCase
{
    public function testCase1(): void
    {
        $this->assertTrue(true);
    }
}