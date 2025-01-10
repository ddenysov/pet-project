<?php
declare(strict_types=1);

namespace Tests\Domain\Event;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\StringValue;
use Common\Domain\ValueObject\TextValue;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Tests\Domain\Event\Stub\BlogCreatedEvent;

final class EventTest extends TestCase
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

        $array = $event->toArray();
        $this->assertTrue(isset($array['id']));
        $this->assertTrue(Uuid::isValid(($array['id'])));
        $this->assertTrue(isset($array['aggregateId']));
        $this->assertTrue(Uuid::isValid(($array['aggregateId'])));
        $this->assertEquals('Blog Title', $event->getTitle()->toString());
        $this->assertEquals('Blog Title', $array['title']);
        $this->assertEquals('Blog Description', $event->getDescription()->toString());
        $this->assertEquals('Blog Description', $array['description']);
    }
}