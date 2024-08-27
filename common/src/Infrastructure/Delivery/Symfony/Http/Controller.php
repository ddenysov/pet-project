<?php

namespace Common\Infrastructure\Delivery\Symfony\Http;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Controller
{

    public function __construct(
        protected readonly CommandBus $commandBus,
        protected readonly QueryBus $queryBus,
        protected LoggerInterface $logger
    ) {
    }
}