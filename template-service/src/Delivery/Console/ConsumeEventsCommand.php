<?php

namespace Template\Delivery\Console;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'events:consume',
    description: 'Add a short description for your command',
)]
class ConsumeEventsCommand extends \Common\Delivery\Console\ConsumeEventsCommand
{
    protected function getConsumerGroup(): string
    {
        return 'template-group';
    }

    protected function getTopic(): string
    {
        return 'real-topic';
    }
}
