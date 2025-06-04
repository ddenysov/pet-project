<?php

use Denysov\Demo\Container\SymfonyHttpKernel;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Zinc\Core\DataStore\Criteria;
use Zinc\Core\DataStore\DataStoreInterface;
use Zinc\Core\Integration\Channel;
use Zinc\Core\Integration\Message;
use Zinc\Core\Integration\MessagePublisherInterface;
use Zinc\Core\Logging\Logger;

require __DIR__ . '/vendor/autoload.php';

$messagePublisher = null;
try {
    $kernel = new SymfonyHttpKernel('local', true);
    $kernel->boot();
    $container   = $kernel->getContainer();
    $httpFactory = new HttpFoundationFactory();
    $logger      = $container->get(LoggerInterface::class);
    Logger::setLogger($logger);
    $store = $container->get(DataStoreInterface::class);
    /**
     * @var MessagePublisherInterface $messagePublisher
     */
    $messagePublisher = $container->get(MessagePublisherInterface::class);
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
