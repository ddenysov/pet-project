<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\DataStore\DataStoreInterface;
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
                'id' => rand(1, 100),
                'aggregate_id' => md5((string) rand(1, 10000)),
                'aggregate_type' => 'aaaaa',
                'playhead' => '1',
                'event_type' => 'qwqwqw',
                'payload' => 'qwqwqw',
                'metadata' => 'wewewe',
                //'recorded_at' => '',
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
