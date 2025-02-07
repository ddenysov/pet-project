<?php

namespace Common\Application\Broker\Transformer;

use Common\Application\Broker\Port\MessageCollection;
use Common\Domain\Event\Event;
use Common\Application\Broker\Transformer\Port\EventToMessageTransformer;

class EventToMessageTransformerFactory
{
    /**
     * @var array
     */
    private array $transformers = [];

    public function registerTransformer(EventToMessageTransformer $transformer): void {
        $this->transformers[] = $transformer;
    }

    /**
     * @param Event $event
     * @return MessageCollection
     */
    public function transform(Event $event): MessageCollection
    {
        $messages = [];
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($event)) {
                $messages[] = $transformer->transform($event);
            }
        }
        return new \Common\Application\Broker\MessageCollection($messages);
    }
}