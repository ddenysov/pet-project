<?php

use Zinc\Core\DataStore\Criteria;
use Zinc\Core\DataStore\DataStoreInterface;
use Zinc\Core\Integration\Channel;
use Zinc\Core\Integration\Message;
use Zinc\Core\Integration\MessagePublisherInterface;
use Zinc\Core\Kernel\Kernel;
use Zinc\Core\Kernel\KernelConfig;
use Zinc\Core\Logging\Logger;

require dirname(__DIR__) . '/vendor/autoload.php';

$messagePublisher = null;
try {
    $kernel = new Kernel(new KernelConfig(['base_dir' => dirname(__DIR__)]));

    $store = $kernel->getContainer()->get(DataStoreInterface::class);
    /**
     * @var MessagePublisherInterface $messagePublisher
     */
    $messagePublisher = $kernel->getContainer()->get(MessagePublisherInterface::class);
} catch (Throwable $e) {
    Logger::error($e->getMessage());
}

while (true) {
    try {
        $result = $store->find(
            'outbox',
            new Criteria('published_at', Criteria::OP_NULL),
        );

        Logger::debug('Result', [
            'time'   => time(),
            'result' => $result,
        ]);

        foreach ($result as $row) {
            Logger::debug('Ping', [
                'time' => time(),
                'row'  => $row,
            ]);

            $messagePublisher->publish(
                new Message(),
                new Channel(),
                fn () => $store->update(
                    'outbox',
                    new Criteria('id', '=', $row['id']),
                    [
                        'published_at' => date('Y-m-d H:i:s'),
                    ]
                ),
            );

        }


    } catch (Throwable $e) {
        Logger::error($e->getMessage());
        usleep(500_000);
    }

    usleep(1_000_000);
}
