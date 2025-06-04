<?php
declare(strict_types=1);

namespace Zinc\Core\Messaging\Symfony\RoadRunner;

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;
use Zinc\Core\Logging\Logger;
use Zinc\Core\Messaging\Symfony\Serializer\CloudEventSerializer;

class RoadRunnerFactory implements TransportFactoryInterface
{

    public function __construct()
    {
    }

    #[\Override] public function createTransport(#[\SensitiveParameter] string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new RoadRunnerTransport(new CloudEventSerializer());
    }

    #[\Override] public function supports(#[\SensitiveParameter] string $dsn, array $options): bool
    {
        Logger::info('Is supports', [
            'value' => substr_count( $dsn, 'rr') > 0
        ]);

        return substr_count( $dsn, 'rr') > 0;
    }
}