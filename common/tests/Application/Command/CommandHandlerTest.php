<?php
declare(strict_types=1);

namespace Tests\Application\Command;

use Common\Application\EventStore\EventStore;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use Common\Infrastructure\EventStore\Memory\EventRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
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
        // ADD EVENT BUS
        $commandHandler = new StubCreateBlogPostCommandHandler(
            new StubBlogPostRepository(),
            new EventStore(
                $messageRepository,
                $eventRepository,
            ),
        );

        $uuid = Uuid::create();
        $commandHandler->handle(new StubCreateBlogPostCommand(
            id: $uuid->toString(),
            title: 'Blog Post Title',
            description: 'Blog Post Description'
        ));
        $this->assertTrue(true);
        dd($eventRepository->stream($uuid));
    }
}