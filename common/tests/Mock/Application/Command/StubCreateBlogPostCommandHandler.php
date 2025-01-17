<?php

namespace Tests\Mock\Application\Command;

use Common\Application\Broker\Message;
use Common\Application\Broker\Port\OutboxMessageStorage;
use Common\Application\Outbox\Port\Outbox;
use Common\Domain\Event\Event;
use Common\Domain\Event\EventStream;
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
     * @param Outbox $outbox
     */
    public function __construct(
        private readonly StubBlogPostRepository $repository,
        private readonly OutboxMessageStorage $messageStorage,
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
            StubBlogId::create(), // Creates a new StubBlogId, likely using a UUID.
            new StubBlogTitle('Blog Title'), // Creates a new StubBlogTitle value object.
            new StubBlogDescription('Blog Description'), // Creates a new StubBlogDescription value object.
        );

        // Release the accumulated events from the aggregate.
        // This typically returns an array of Domain Events that represent the changes made to the aggregate.
        /**
         * @var Event[] $events
         */
        $events = $this->repository->save($blogPost);

        foreach ($events as $event) {
            $this->messageStorage->store(new Message(
                $event->getId()->toString(),
                $event->toArray(),
            ));
        }
    }
}