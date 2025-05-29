<?php
declare(strict_types=1);

namespace Denysov\Demo\Delivery\Http;

use Denysov\Demo\Application\Command\Ping\PingCommand;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Zinc\Core\Command\Bridge\Symfony\MessengerCommandBus;
use Zinc\Core\Command\CommandBusInterface;
use Zinc\Core\Event\EventBus;
use Zinc\Core\Logging\Logger;

class IndexController
{
    public function __invoke(CommandBusInterface $bus, LoggerInterface $logger)
    {
        Logger::error('trolololo');
        $command = new PingCommand();
        $bus->dispatch(new PingCommand());
        return new JsonResponse([
            'framework' => 'symfony',
            'test'      => class_exists(Logger::class),
            'time'      => rand(10, 99),
        ]);
    }
}