<?php

namespace User\Infrastructure\Adapter\Bus\Query;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements \User\Application\Ports\Output\Bus\QueryBus
{
    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(private MessageBusInterface $bus)
    {
    }

    /**
     * @param mixed $query
     * @return mixed
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function execute(mixed $query): mixed
    {
        /**
         * @var Envelope $response
         */
        $response = $this->bus->dispatch($query);
        if (count($response->all(HandledStamp::class)) > 1) {
            throw new \Exception('Query should only have one handler');
        }

        return $response->last(HandledStamp::class)->getResult();
    }
}