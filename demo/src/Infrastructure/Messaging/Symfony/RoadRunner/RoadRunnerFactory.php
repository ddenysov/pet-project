<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Messaging\Symfony\RoadRunner;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Zinc\Core\Logging\Logger;

class RoadRunnerFactory implements TransportFactoryInterface
{
    #[\Override] public function createTransport(#[\SensitiveParameter] string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new RoadRunnerTransport();
    }

    #[\Override] public function supports(#[\SensitiveParameter] string $dsn, array $options): bool
    {
        Logger::info('Is supports', [
            'value' => substr_count( $dsn, 'rr') > 0
        ]);

        return substr_count( $dsn, 'rr') > 0;
    }
}