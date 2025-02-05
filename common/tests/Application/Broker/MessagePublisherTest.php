<?php
declare(strict_types=1);

namespace Tests\Application\Broker;

use Common\Application\Broker\Message;
use Common\Application\Broker\MessageChannel;
use Common\Application\Broker\MessagePublisher;
use Common\Domain\ValueObject\Uuid;
use Common\Infrastructure\Broker\Memory\MessageBroker;
use Common\Infrastructure\Broker\Memory\MessageOutboxRepository;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;

final class MessagePublisherTest extends TestCase
{
    public function testCase1(): void
    {
        $messageRepository = new MessageOutboxRepository();
        $messageRepository->save(new Message(
            Uuid::create()->toString(),
            'some-message',
            ['key' => 'value'],
            new MessageChannel('some-channel'),
        ));

        $messageBroker = new MessageBroker();
        $publisher = new MessagePublisher($messageRepository, $messageBroker);

        $publisher->publish(5, function () {
            return true;
        });

        $message = $messageBroker->consume(new MessageChannel('some-channel'));
        $this->assertEquals('value', $message->getPayload()['key']);
        $message = $messageRepository->find($message->getId());
        $this->assertEquals('complete', $message->getStatus());
    }

    public function testCase2Doctrine(): void
    {
        $connectionParams = [
            'driver' => 'pdo_sqlite',
            'memory' => true, // Включает SQLite в оперативной памяти
        ];

        $connection = DriverManager::getConnection($connectionParams);
        $connection->executeStatement("
            CREATE TABLE message_outbox (
                id TEXT PRIMARY KEY,
                event_id TEXT NOT NULL,
                name TEXT NOT NULL,
                payload TEXT NOT NULL,
                status TEXT NOT NULL,
                channel TEXT NOT NULL,
                created_at DATETIME NOT NULL
            )
        ");

        $messageRepository = new \Common\Infrastructure\Broker\Doctrine\MessageOutboxRepository(
            $connection,
        );
        $messageRepository->save(new Message(
            Uuid::create()->toString(),
            Uuid::create()->toString(),
            'some-message',
            ['key' => 'value'],
            new MessageChannel('some-channel'),
        ));

        $messageBroker = new MessageBroker();
        $publisher = new MessagePublisher($messageRepository, $messageBroker);

        $publisher->publish(5, function () {
            return true;
        });

        $message = $messageBroker->consume(new MessageChannel('some-channel'));
        $this->assertEquals('value', $message->getPayload()['key']);
        $message = $messageRepository->find($message->getId());
        $this->assertEquals('complete', $message->getStatus());
    }
}