<?php

namespace Track\Application\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Psr\Log\LoggerInterface;

class CreateRideCommandHandler extends CommandHandler
{
    public function __construct(ServiceContainer $container, LoggerInterface $logger)
    {
        parent::__construct($container, $logger);
    }

    /**
     * @param CreateTrackCommand $command
     * @return void
     */
    protected function handle(CreateTrackCommand $command): void
    {

    }
}