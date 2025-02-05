<?php
declare(strict_types=1);

namespace Tests\Application\Command;

use Common\Application\Broker\Transformer\EventToMessageTransformer;
use Common\Application\Broker\Transformer\TransformerRegistry;
use Common\Application\EventStore\EventStore;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use Common\Infrastructure\EventStore\Memory\EventRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Application\Broker\Transformer\BlogPostCreatedV1Transformer;
use Tests\Mock\Application\Broker\Transformer\BlogPostCreatedV2Transformer;
use Tests\Mock\Application\Broker\Transformer\BlogPostEditedV1Transformer;
use Tests\Mock\Application\Command\StubCreateBlogPostCommand;
use Tests\Mock\Application\Command\StubCreateBlogPostCommandHandler;
use Tests\Mock\Domain\Repository\StubBlogPostRepository;

final class CommandHandlerTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws Exception
     */
    public function testCase1(): void
    {
        $eventRepository = new EventRepository();
        $messageRepository = new MessageOutboxRepository();
        $transformerRegistry = new TransformerRegistry();
        $transformerRegistry->register(new BlogPostCreatedV1Transformer());
        $transformerRegistry->register(new BlogPostCreatedV2Transformer());
        $transformerRegistry->register(new BlogPostEditedV1Transformer());
        $messageTransformer = new EventToMessageTransformer($transformerRegistry);

        // ADD EVENT BUS
        $commandHandler = new StubCreateBlogPostCommandHandler(
            new EventStore(
                $messageRepository,
                $eventRepository,
                $messageTransformer,
            ),
        );

        $uuid = Uuid::create();
        $commandHandler->handle(new StubCreateBlogPostCommand(
            id: $uuid->toString(),
            title: 'Blog Post Title',
            description: 'Blog Post Description'
        ));
        $this->assertTrue(true);

        $actualEvents = $eventRepository->stream($uuid);

        $this->assertTrue($uuid->equals($actualEvents[0]->getAggregateId()));
        $this->assertEquals('Blog Post Title', $actualEvents[0]->getTitle()->toString());
        $this->assertEquals('Blog Post Description', $actualEvents[0]->getDescription()->toString());

        $messages = $messageRepository->pending()->get();
        $this->assertEquals($actualEvents[0]->getId()->toString(), $messages[0]->getPayload()['id']);
        $this->assertEquals($uuid->toString(), $messages[0]->getPayload()['aggregateId']);
        $this->assertEquals('Blog Post Title', $messages[0]->getPayload()['title']);
        $this->assertEquals('Blog Post Description', $messages[0]->getPayload()['description']);
    }
}