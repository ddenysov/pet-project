<?php

namespace Common\Delivery\Console;

use Common\Application\EventHandler\Port\EventConsumer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'events:consume',
    description: 'Add a short description for your command',
)]
abstract class ConsumeEventsCommand extends Command
{
    /**
     * @param EventConsumer $eventConsumer
     */
    public function __construct(
        private EventConsumer $eventConsumer,
        private LoggerInterface $logger
    ) {
        parent::__construct('ololo');
    }


    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info('Starting consumer worker');
        $this->eventConsumer->consume($this->getConsumerGroup(), $this->getTopic());

        return Command::SUCCESS;
    }

    /**
     * @return string
     */
    abstract protected function getConsumerGroup(): string;

    /**
     * @return string
     */
    abstract protected function getTopic(): string;
}
