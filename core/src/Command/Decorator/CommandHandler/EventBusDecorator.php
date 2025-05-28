<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Event\EventBusInterface;
use Zinc\Core\Logging\Logger;

class EventBusDecorator implements CommandHandlerInterface
{
    public function __construct(private CommandHandlerInterface $inner, private EventBusInterface $eventBus)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $events = $this->inner->__invoke($command);

        Logger::info('Publishing events start', [
            'events' => $events,
        ]);
        foreach ($events as $event) {
            Logger::info('Publishing event: ', [
                'event' => $event,
            ]);
            $this->eventBus->dispatch($event);
        }
        Logger::info('Publishing events finished');

        return $events;
    }
}
