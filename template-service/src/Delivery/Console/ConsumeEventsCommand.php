<?php

namespace Template\Delivery\Console;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'events:consume',
    description: 'Add a short description for your command',
)]
class ConsumeEventsCommand extends \Common\Delivery\Console\ConsumeEventsCommand
{
    /**
     * @return string
     */
    protected function getConsumerGroup(): string
    {
        return 'template-group';
    }

    /**
     * @return string
     */
    protected function getTopic(): string
    {
        return getenv('CONSUMER_CHANNEL', 'default');
    }
}
