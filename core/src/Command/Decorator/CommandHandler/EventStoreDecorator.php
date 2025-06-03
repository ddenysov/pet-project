<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\DataStore\DataStoreInterface;
use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Logging\Logger;

class EventStoreDecorator implements CommandHandlerInterface
{
    private static $x = 0;

    public function __construct(private CommandHandlerInterface $inner, private DataStoreInterface $store)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);

        $this->store->transactional(function () {
            $this->store->insert('event_store', [
                'id' => Uuid::create()->toString(),
                'aggregate_id' => Uuid::create()->toString(),
                'aggregate_type' => 'aaaaa',
                'playhead' => '1',
                'event_type' => 'qwqwqw',
                'payload' => 'qwqwqw',
                'metadata' => 'wewewe',
            ]);

            $this->store->insert('outbox', [
                'id' => Uuid::create()->toString(),
                'aggregate_id' => Uuid::create()->toString(),
                'aggregate_type' => 'aaaaa',
                'message_type' => 'asas',
                'payload' => '[]',
                'metadata' => '[]',
                'created_at' => date('Y-m-d H:i:s'),
                'attempts' => '0',
            ]);

            Logger::info('Saving events to Event Store');
            self::$x++;
            if (self::$x < 2) {
                Logger::error('Events failed to save: Conflict');
                throw new \Exception('Failed');
            }
            Logger::info('Events saved');
        });

        return $result;
    }
}
