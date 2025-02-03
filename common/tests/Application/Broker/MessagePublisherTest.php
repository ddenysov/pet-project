<?php
declare(strict_types=1);

namespace Tests\Application\Broker;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\MessagePublisher;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageBroker;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use PHPUnit\Framework\TestCase;

final class MessagePublisherTest extends TestCase
{
    public function testCase1(): void
    {
        $messageRepository = new MessageOutboxRepository();
        $messageRepository->save(new Message(Uuid::create()->toString(), ['key' => 'value']));


        $messageBroker = new MessageBroker();
        $publisher = new MessagePublisher($messageRepository, $messageBroker);

        $publisher->publish(5, function () {
            return true;
        });

        $message = $messageBroker->consume(new MessageChannel());
        $this->assertEquals('value', $message->getPayload()['key']);
        $message = $messageRepository->find($message->getId());
        $this->assertEquals('complete', $message->getStatus());
    }
}