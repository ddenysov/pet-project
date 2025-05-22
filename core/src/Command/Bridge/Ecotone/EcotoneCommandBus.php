<?php

declare(strict_types=1);

namespace Zinc\Core\Command\Bridge\Ecotone;

use Zinc\Core\Command\AbstractCommandBus;
use Zinc\Core\Command\Command;
use Zinc\Core\Command\MiddlewareInterface;
use Ecotone\Messaging\Config\GatewayProxy;

/**
 * CommandBus adapter backed by Ecotone.
 */
final class EcotoneCommandBus extends AbstractCommandBus
{
    public function __construct(
        private GatewayProxy $gateway,
        MiddlewareInterface ...$middleware,
    ) {
        parent::__construct(...$middleware);
    }

    protected function innerDispatch(Command $command): mixed
    {
        // Assumes a gateway method named "send"
        return $this->gateway->send($command);
    }
}
