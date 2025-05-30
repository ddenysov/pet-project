<?php
declare(strict_types=1);

namespace Denysov\Demo\Infrastructure\Messaging\Symfony\Serializer;

use CloudEvents\V1\CloudEventImmutable;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializer;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializer;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;

final class CloudEventSerializer implements MessengerSerializer
{
    /**
     * @param SymfonySerializer $payloadSerializer
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

        // превращаем объект сообщения в чистый массив
        $data = $this->payloadSerializer->normalize($message, 'json');

        $event = new CloudEventImmutable();

        /**
        // техконтекст из конверта (если есть)
        if ($stamp = $envelope->last(TraceparentStamp::class)) {
            $event = $event->with('traceparent', $stamp->traceparent);
        }
        if ($stamp = $envelope->last(CorrelationIdStamp::class)) {
            $event = $event->with('correlationid', $stamp->id);
        }
         */

        return [
            'body'    => json_encode($event, JSON_UNESCAPED_UNICODE),
            'headers' => ['content_type' => 'application/cloudevents+json'],
        ];
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