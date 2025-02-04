<?php

namespace Common\Application\Broker\Transformer;

use Common\Application\Broker\Port\MessageCollection;
use Common\Domain\Event\Event;

class EventToMessageTransformer
{

    public function __construct(private TransformerRegistry $registry)
    {
    }

    public function transform(Event $event): MessageCollection
    {
        $messages = [];
        foreach ($this->registry->getTransformers() as $transformer) {
            if ($transformer->supports($event)) {
                $messages[] = $transformer->transform($event);
            }
        }
        return new \Common\Application\Broker\MessageCollection($messages);
    }
}