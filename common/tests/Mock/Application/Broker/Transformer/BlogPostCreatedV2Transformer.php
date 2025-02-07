<?php

namespace Tests\Mock\Application\Broker\Transformer;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\Transformer\Port\EventToMessageTransformer;
use Common\Application\Broker\Transformer\Port\MessageTransformer;
use Common\Domain\Event\Event;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;

class BlogPostCreatedV2Transformer implements EventToMessageTransformer
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
            'blog-post-created-v2',
            $event->toArray() + ['version' => 2],
            new MessageChannel('blog-post')
        );
    }
}