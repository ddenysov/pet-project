<?php

namespace Tests\Mock\Application\Command;

use Common\Application\Broker\Message;
use Common\Application\Broker\Port\OutboxMessageStorage;
use Common\Application\EventStore\Port\EventStore;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;
use Common\Domain\Event\Port\EventStream;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Tests\Mock\Domain\Aggregate\StubBlogPost;
use Tests\Mock\Domain\Repository\Port\StubBlogPostRepository;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

class StubCreateBlogPostCommandHandler
{
    /**
     * @param StubBlogPostRepository $repository
     * @param EventStore $eventStore
     */
    public function __construct(
        private readonly StubBlogPostRepository $repository,
        private readonly EventStore $eventStore,
    ) {
    }

    /**
     * @throws InvalidUuidException
     * @throws \Exception
     */
    public function handle(StubCreateBlogPostCommand $command): void
    {
        // Create a new StubBlogPost aggregate.
        // The factory method 'create' likely handles the internal creation logic and event recording.
        $blogPost = StubBlogPost::create(
            new StubBlogId($command->id), // Creates a new StubBlogId, likely using a UUID.
            new StubBlogTitle($command->title), // Creates a new StubBlogTitle value object.
            new StubBlogDescription($command->description), // Creates a new StubBlogDescription value object.
        );

        // Release the accumulated events from the aggregate.
        // This typically returns an array of Domain Events that represent the changes made to the aggregate.
        $this->eventStore->append($blogPost->releaseEvents());
    }
}