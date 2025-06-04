<?php
declare(strict_types=1);

namespace Zinc\Core\Messaging\Symfony\Serializer;

use CloudEvents\Serializers\JsonSerializer;
use CloudEvents\V1\CloudEvent;
use DateTimeImmutable;
use Denysov\Demo\Infrastructure\Messaging\Symfony\Serializer\CorrelationIdStamp;
use Denysov\Demo\Infrastructure\Messaging\Symfony\Serializer\TraceparentStamp;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializer;

final class CloudEventSerializer implements MessengerSerializer
{
    /**
     * @param string $source
     */
    public function __construct(
        private string $source = 'urn:service:demo'
    ) {}

    /** @return array{body:string,headers:array} */
    public function encode(Envelope $envelope): array
    {
        $message      = $envelope->getMessage();
        $messageClass = $message::class;


        $event = new CloudEvent(
            id: Uuid::uuid4()->toString(),
            source: 'TBD',
            type: $messageClass,
            data: json_decode(json_encode($message), true),
            time: (new DateTimeImmutable()),
            extensions: []
        );
        $payload = JsonSerializer::create()->serializeStructured($event);

        /**
        // техконтекст из конверта (если есть)
        if ($stamp = $envelope->last(TraceparentStamp::class)) {
            $event = $event->with('traceparent', $stamp->traceparent);
        }
        if ($stamp = $envelope->last(CorrelationIdStamp::class)) {
            $event = $event->with('correlationid', $stamp->id);
        }
         */


        return json_decode($payload, true);
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $raw = $encodedEnvelope['body'] ?? null;
        if (!\is_string($raw) || $raw === '') {
            throw new MessageDecodingFailedException('Empty body');
        }

        $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        foreach (['type', 'data'] as $required) {
            if (!isset($decoded[$required])) {
                throw new MessageDecodingFailedException("Missing '$required' field");
            }
        }

        $messageClass = $decoded['type'];
        if (!class_exists($messageClass)) {
            throw new MessageDecodingFailedException("Unknown class $messageClass");
        }

        $message  = $this->payloadSerializer->denormalize($decoded['data'], $messageClass, 'json');
        $envelope = new Envelope($message);

        // восстанавливаем трейсы/корреляцию
        if (isset($decoded['traceparent'])) {
            $envelope = $envelope->with(new TraceparentStamp($decoded['traceparent']));
        }
        if (isset($decoded['correlationid'])) {
            $envelope = $envelope->with(new CorrelationIdStamp($decoded['correlationid']));
        }

        return $envelope;
    }
}