<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Proxy\CommandHandler;

use Zinc\Core\Command\CommandHandlerInterface;
use Zinc\Core\Command\CommandInterface;
use Zinc\Core\Logging\LogManager;

class LoggerProxy implements CommandHandlerInterface
{
    public function __construct(private CommandHandlerInterface $inner, private LogManager $logManager)
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $result = $this->inner->__invoke($command);
        $this->logManager->debug(sprintf('PROCESSED: [%s]', $this->inner::class));

        return $result;
    }
}