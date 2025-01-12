<?php
declare(strict_types=1);

namespace Tests\Domain\Event;

use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

final class EventStreamTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws Exception
     */
    public function testCase1(): void
    {
        $event = new StubBlogPostCreatedEvent(
            new StubBlogTitle('Blog Title'),
            new StubBlogDescription('Blog Description'),
        );
        $event->setAggregateId(Uuid::create());
        $stream = new EventStream();
        $stream[] = $event;

        $this->assertCount(1, $stream);
        $this->assertEquals('Blog Title', $stream[0]->getTitle()->toString());

        foreach ($stream as $item) {
            $this->assertEquals('Blog Title', $item->getTitle()->toString());
        }

        $stream = [];
        $this->assertCount(0, $stream);
    }
}