<?php
declare(strict_types=1);

namespace Tests\Domain\Aggregate;

use Common\Domain\ValueObject\Exception\InvalidUuidException;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Domain\Aggregate\StubBlogPost;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

final class AggregateTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     */
    public function testCase1(): void
    {
        // Create a new StubBlogPost aggregate.
        // The factory method 'create' likely handles the internal creation logic and event recording.
        $blogPost = StubBlogPost::create(
            StubBlogId::create(), // Creates a new StubBlogId, likely using a UUID.
            new StubBlogTitle('Blog Title'), // Creates a new StubBlogTitle value object.
            new StubBlogDescription('Blog Description'), // Creates a new StubBlogDescription value object.
        );

        // Release the accumulated events from the aggregate.
        // This typically returns an array of Domain Events that represent the changes made to the aggregate.
        $events = $blogPost->releaseEvents();

        // Example of more meaningful assertions:
        // Check that one event was released.
        $this->assertCount(1, $events);

        // Check that the event is of the expected type (replace with your actual event class).
        $this->assertInstanceOf(StubBlogPostCreatedEvent::class, $events[0]);

        // Check the data within the event (e.g., title, description).
        $this->assertEquals('Blog Title', $events[0]->getTitle()->toString());
        $this->assertEquals('Blog Description', $events[0]->getDescription()->toString());

        $this->assertEquals('Blog Title', $blogPost->getTitle()->toString());
        $this->assertEquals('Blog Description', $blogPost->getDescription()->toString());
    }
}