<?php

namespace Iam\Delivery\Console;

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'events:consume',
    description: 'Add a short description for your command',
)]
class ConsumeEventsCommand extends Command
{
    private Consumer $consumer;


    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Worker started');

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $consumer = new Consumer($conf);

        $consumer->addBrokers("kafka:9092");

        $topic = $consumer->newTopic("real-topic");

        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

        echo "consumer started" . PHP_EOL;
        while (true) {
            sleep(1);
            $msg = $topic->consume(0, 1000);
            var_dump($msg);
            if (isset($msg->payload)) {
                echo $msg->payload . PHP_EOL;
            }
        }

        return Command::SUCCESS;
    }
}
