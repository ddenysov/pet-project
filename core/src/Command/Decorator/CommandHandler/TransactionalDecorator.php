<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Decorator\CommandHandler;

use Zinc\Core\Command\Command as C;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\DataStore\DataStore;

class TransactionalDecorator implements CommandHandler
{

    public function __construct(
        private CommandHandler $wrapped,
        private DataStore $dataStore
    ) {
    }

    public function __invoke(C $command): mixed
    {
        return $this->dataStore->transactional(function () use ($command) {
            return $this->wrapped->__invoke($command);
        });
    }
}