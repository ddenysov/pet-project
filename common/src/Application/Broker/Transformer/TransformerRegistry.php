<?php

namespace Common\Application\Broker\Transformer;

use Common\Application\Broker\Transformer\Port\MessageTransformer;

class TransformerRegistry
{
    private array $transformers = [];

    public function register(MessageTransformer $messageTransformer): void
    {
        $this->transformers[] = $messageTransformer;
    }

    public function getTransformers(): array
    {
        return $this->transformers;
    }
}