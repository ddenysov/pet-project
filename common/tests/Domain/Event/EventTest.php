<?php
declare(strict_types=1);

namespace Tests\Domain\Event;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

final class EventTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws \Exception
     */
    public function testCase1(): void
    {
        $event = new StubBlogPostCreatedEvent(
            StubBlogId::create(),
            new StubBlogTitle('Blog Title'),
            new StubBlogDescription('Blog Description'),
        );
        $event->setAggregateId(\Common\Domain\ValueObject\Uuid::create());

        $array = $event->toArray();

        //dd($array);

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