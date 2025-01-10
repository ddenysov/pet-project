<?php
declare(strict_types=1);

namespace Domain\Event;

use Common\Domain\Event\EventStream;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Common\Domain\ValueObject\TextValue;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Tests\Domain\Event\Stub\BlogCreatedEvent;

final class EventStreamTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws \Exception
     */
    public function testCase1(): void
    {
        $event = new BlogCreatedEvent(
            new StringValue('Blog Title'),
            new TextValue('Blog Description'),
        );
        $event->setAggregateId(\Common\Domain\ValueObject\Uuid::create());
        $stream = new EventStream();
        $stream[] = $event;

        $this->assertCount(1, $stream);
        $this->assertEquals('Blog Title', $stream[0]->getTitle()->toString());

        foreach ($stream as $item) {
            $this->assertEquals('Blog Title', $item->getTitle()->toString());
        }
    }
}