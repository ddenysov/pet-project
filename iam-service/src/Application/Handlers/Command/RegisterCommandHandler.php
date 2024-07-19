<?php

namespace Iam\Application\Handlers\Command;

use Common\Application\Handlers\Command\Attributes\Transaction;
use Common\Application\Handlers\Command\CommandHandler;
use Common\Application\Handlers\Command\Port\TransactionManager;
use Exception;
use Iam\Domain\Service\RegisterService;

final class RegisterCommandHandler extends CommandHandler
{
    public function __construct(
        private RegisterService $registerService,
        TransactionManager $transactionManager,
    )
    {
        parent::__construct($transactionManager);
    }

    /**
     * @throws Exception
     */
    #[Transaction]
    public function handle(RegisterCommand $command): void
    {
        $events = $this->registerService->execute(email: $command->email,password: $command->password);
    }
}