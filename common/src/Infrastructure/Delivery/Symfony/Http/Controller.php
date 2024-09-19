<?php

namespace Common\Infrastructure\Delivery\Symfony\Http;

use Common\Application\Bus\Port\CommandBus;
use Common\Application\Bus\Port\QueryBus;
use Common\Delivery\Http\Security\Identity;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Controller
{
    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     * @param LoggerInterface $logger
     * @param Identity $identity
     */
    public function __construct(
        protected readonly CommandBus $commandBus,
        protected readonly QueryBus $queryBus,
        protected LoggerInterface $logger,
        protected ?Identity $identity = null,
    ) {
    }

    /**
     * @return Identity
     */
    public function getIdentity(): ?Identity
    {
        return $this->identity;
    }
}