<?php
declare(strict_types=1);

namespace Zinc\Core\Command;

use Zinc\Core\Command\Persistence\AggregatePersistenceManager;
use Zinc\Core\Domain\Event\EventStream;
use Zinc\Core\Domain\Root\Aggregate;

abstract class AbstractCommandHandler implements CommandHandler
{
    public function __construct(
        private AggregatePersistenceManager $manager
    ) {
    }

    protected function persist(Aggregate $aggregate): EventStream
    {
        return $this->manager->persist($aggregate);
    }
}