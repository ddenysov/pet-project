<?php

namespace Track\Application\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Psr\Log\LoggerInterface;
use Track\Domain\Entity\Healthcheck;
use Track\Domain\Repository\Port\HealthCheckRepository;


final class HealthCheckCommandHandler extends CommandHandler
{
    public function __construct(ServiceContainer $container, LoggerInterface $logger, private readonly HealthCheckRepository $repository)
    {
        parent::__construct($container, $logger);
    }


    protected function handle(HealthCheckCommand $command): void
    {
        $this->logger->info('Command: Healthcheck OK', [
            'date' => date('Y-m-d H:i:s'),
        ]);

        $entity = Healthcheck::execute();

        $this->repository->save($entity);
    }
}