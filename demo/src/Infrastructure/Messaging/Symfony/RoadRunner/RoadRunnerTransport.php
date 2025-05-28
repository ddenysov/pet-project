<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Messaging\Symfony\RoadRunner;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;

class RoadRunnerTransport implements TransportInterface
{
    #[\Override] public function get(): iterable
    {
        // TODO: Implement get() method.
    }

    #[\Override] public function ack(Envelope $envelope): void
    {
        // TODO: Implement ack() method.
    }

    #[\Override] public function reject(Envelope $envelope): void
    {
        // TODO: Implement reject() method.
    }

    #[\Override] public function send(Envelope $envelope): Envelope
    {
        // TODO: Implement send() method.
    }
}