<?php

namespace Template\Application\Handlers\Command;

use Common\Application\Handlers\Command\CommandHandler;


final class HealthCheckCommandHandler extends CommandHandler
{
    protected function handle(HealthCheckCommand $command): void
    {
        $this->logger->info('Command: Healthcheck OK', [
            'date' => date('Y-m-d H:i:s'),
        ]);
    }
}