<?php
declare(strict_types=1);

namespace Zinc\Core\Integration\Bridge\InMemory;

use Zinc\Core\Integration\MessageChannelInterface;
use Zinc\Core\Integration\MessageInterface;
use Zinc\Core\Integration\MessagePublisherInterface;
use Zinc\Core\Logging\Logger;

/**
 * In-memory implementation of MessagePublisherInterface.
 *
 * Designed mainly for unit tests and local development where persisting
 * messages to an external broker is unnecessary.  Not thread-safe by design.
 */
final class InMemoryMessagePublisher implements MessagePublisherInterface
{
    /** @var list<array{message: MessageInterface, channel: MessageChannelInterface}> */
    private array $buffer = [];

    /**
     * {@inheritdoc}
     */
    public function publish(
        MessageInterface $message,
        MessageChannelInterface $channel,
        \Closure $onSuccess = null,
        \Closure $onFail = null,
    ): void {
        try {
            // Store the message in memory
            $this->buffer[] = [
                'message' => $message,
                'channel' => $channel,
            ];

            Logger::debug('Publishing message to Event Broker');

            // Invoke success hook if provided
            $onSuccess?->call($this, $message, $channel);
        } catch (\Throwable $e) {
            // Invoke failure hook if provided
            $onFail?->call($this, $e);

            throw $e; // Re-throw so callers can handle the error upstream
        }
    }

    /**
     * Returns the internal buffer without clearing it.
     *
     * @return list<array{message: MessageInterface, channel: MessageChannelInterface}>
     */
    public function messages(): array
    {
        return $this->buffer;
    }

    /**
     * Returns all messages and clears the buffer (useful for assertions in tests).
     *
     * @return list<array{message: MessageInterface, channel: MessageChannelInterface}>
     */
    public function flush(): array
    {
        $messages      = $this->buffer;
        $this->buffer  = [];

        return $messages;
    }
}