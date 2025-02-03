<?php
declare(strict_types=1);

namespace Tests\Application\Broker;

use Common\Application\Broker\MessagePublisher;
use Common\Infrastructure\Broker\Memory\MessageBroker;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use PHPUnit\Framework\TestCase;

final class MessagePublisherTest extends TestCase
{
    public function testCase1(): void
    {
        $messageRepository = new MessageOutboxRepository();
        $messageBroker = new MessageBroker();
        $publisher = new MessagePublisher($messageRepository, $messageBroker);

        $this->assertTrue(true);
    }
}