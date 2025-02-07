<?php

namespace Tests\Mock\Application\Broker\Transformer;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\Transformer\Port\EventToMessageTransformer;
use Common\Application\Broker\Transformer\Port\MessageTransformer;
use Common\Domain\Event\Event;
use Common\Domain\ValueObject\Uuid;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\Event\StubBlogPostEditedEvent;

class BlogPostEditedV1Transformer implements EventToMessageTransformer
{
    #[\Override] public function supports(Event $event): bool
    {
        return $event instanceof StubBlogPostEditedEvent;
    }

    /**
     * @throws \Exception
     */
    #[\Override] public function transform(Event $event): Message
    {
        return new Message(
            Uuid::create()->toString(),
            $event->getId()->toString(),
            'blog-post-edited-v1',
            $event->toArray() + ['version' => 1],
            new MessageChannel('blog-post')
        );
    }
}