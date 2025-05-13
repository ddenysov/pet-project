<?php
declare(strict_types=1);

namespace Tests\Application\Broker;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\MessagePublisher;
use Common\Application\Broker\Transformer\EventToMessageTransformer;
use Common\Application\Broker\Transformer\EventToMessageTransformerFactory;
use Common\Application\Broker\Transformer\MessageToEventTransformerFactory;
use Common\Application\Broker\Transformer\TransformerRegistry;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageBroker;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Application\Broker\Transformer\BlogPostCreatedV1Transformer;
use Tests\Mock\Application\Broker\Transformer\BlogPostCreatedV2Transformer;
use Tests\Mock\Application\Broker\Transformer\BlogPostEditedV1Transformer;
use Tests\Mock\Domain\Event\StubBlogPostCreatedEvent;
use Tests\Mock\Domain\ValueObject\StubBlogDescription;
use Tests\Mock\Domain\ValueObject\StubBlogId;
use Tests\Mock\Domain\ValueObject\StubBlogTitle;

final class MessageTransformerTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     */
    public function testEventToMessage(): void
    {
        $messageTransformer = new EventToMessageTransformerFactory();
        $messageTransformer->registerTransformer(new BlogPostCreatedV1Transformer());
        $messageTransformer->registerTransformer(new BlogPostCreatedV2Transformer());
        $messageTransformer->registerTransformer(new BlogPostEditedV1Transformer());

        $messages = $messageTransformer->transform(new StubBlogPostCreatedEvent(
            id: StubBlogId::create(),
            title: new StubBlogTitle('Blog Post Title'),
            description: new StubBlogDescription('Blog Post Description'),
        ));

        $this->assertCount(2, $messages);

        $this->assertEquals('Blog Post Title', $messages[0]->getPayload()['title']);
        $this->assertEquals('Blog Post Description', $messages[0]->getPayload()['description']);
        $this->assertEquals(1, $messages[0]->getPayload()['version']);
        $this->assertEquals('blog-post-created-v1', $messages[0]->getName());
        $this->assertEquals('blog-post', $messages[0]->getChannel()->getName());


        $this->assertEquals('Blog Post Title', $messages[1]->getPayload()['title']);
        $this->assertEquals('Blog Post Description', $messages[1]->getPayload()['description']);
        $this->assertEquals(2, $messages[1]->getPayload()['version']);
        $this->assertEquals('blog-post-created-v2', $messages[1]->getName());
        $this->assertEquals('blog-post', $messages[1]->getChannel()->getName());
    }

    public function testMessageToEvent()
    {
        $transformer = new MessageToEventTransformerFactory();
    }
}