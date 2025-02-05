<?php

namespace Tests\Mock\Application\Broker\Transformer;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\Transformer\Port\MessageTransformer;
use Common\Domain\Event\Event;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;

class BlogPostCreatedV1Transformer implements MessageTransformer
{
    #[\Override] public function supports(Event $event): bool
    {
        return $event instanceof StubBlogPostCreatedEvent;
    }

    /**
     * @throws \Exception
     */
    #[\Override] public function transform(Event $event): Message
    {
        return new Message(
            null,
            $event->getId()->toString(),
            'blog-post-created-v1',
            $event->toArray() + ['version' => 1],
            new MessageChannel('blog-post')
        );
    }
}