<?php
declare(strict_types=1);

namespace Tests\Application\Broker;

use Common\Application\Broker\MessagePublisher;
use Common\Application\EventStore\EventStore;
use Common\Domain\ValueObject\Exception\InvalidUuidException;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageBroker;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use Common\Infrastructure\EventStore\Memory\EventRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mock\Application\Command\StubCreateBlogPostCommand;
use Tests\Mock\Application\Command\StubCreateBlogPostCommandHandler;
use Tests\Mock\Domain\Repository\StubBlogPostRepository;

final class MessagePublisherTest extends TestCase
{
    /**
     * @throws InvalidUuidException
     * @throws Exception
     */
    public function testCase1(): void
    {
        $messageRepository = new MessageOutboxRepository();
        $messageBroker = new MessageBroker();
        $publisher = new MessagePublisher($messageRepository, $messageBroker);

        $this->assertTrue(true);
    }
}