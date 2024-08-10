<?php

namespace Iam\Delivery\Console;

use Common\Application\Bus\Port\EventBus;
use Common\Application\Serializer\Event\EventSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Iam\Infrastructure\Persistence\Doctrine\Entity\User;
use Psr\Log\LoggerInterface;
use \RdKafka\Conf;
use \RdKafka\Consumer;
use \RdKafka\Producer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Uuid;

#[AsCommand(
    name: 'events:consume',
    description: 'Add a short description for your command',
)]
class ConsumeEventsCommand extends Command
{
    /**
     * @param LoggerInterface $logger
     * @param EntityManagerInterface $entityManager
     * @param EventSerializer $eventSerializer
     */
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private EventSerializer $eventSerializer,
        private EventBus $eventBus,
    ) {
        parent::__construct('ololo');
    }


    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $io = new SymfonyStyle($input, $output);

            $io->success('Worker started');

            $conf = new \RdKafka\Conf();

            // Set the group id. This is required when storing offsets on the broker
            $conf->set('group.id', 'myConsumerGroup');

            // Emit EOF event when reaching the end of a partition
            $conf->set('enable.partition.eof', 'true');

            $rk = new \RdKafka\Consumer($conf);
            $rk->addBrokers("kafka:9092");

            $topicConf = new \RdKafka\TopicConf();
            $topicConf->set('auto.commit.interval.ms', 100);

            // Set the offset store method to 'file'
            $topicConf->set('offset.store.method', 'broker');

            // Alternatively, set the offset store method to 'none'
            // $topicConf->set('offset.store.method', 'none');

            // Set where to start consuming messages when there is no initial offset in
            // offset store or the desired offset is out of range.
            // 'earliest': start from the beginning
            $topicConf->set('auto.offset.reset', 'earliest');

            $topic = $rk->newTopic("real-topic", $topicConf);

            // Start consuming partition 0
            $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);

            while (true) {
                $message = $topic->consume(0, 120*10000);
                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        $payload = json_decode($message->payload, true)['payload'];
                        $name = json_decode($message->payload)->name;

                        $event = $this->eventSerializer->deserialize($name, $payload);
                        $this->eventBus->dispatch($event);

                        $this->logger->info('Received an event: ' . $name, [
                            'id' => $payload['id'],
                            'payload' => $payload,
                        ]);
                        var_dump($message->payload);

                        $user = new User();
                        $user->setId(Uuid::fromString($payload['aggregateId']));
                        $user->setEmail($payload['email']);
                        $user->setPassword($payload['password']);
                        $this->entityManager->persist($user);
                        $this->entityManager->flush();

                        break;
                    case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                        echo "No more messages; will wait for more\n";
                        break;
                    case RD_KAFKA_RESP_ERR__TIMED_OUT:
                        echo "Timed out\n";
                        break;
                    default:
                        throw new \Exception($message->errstr());
                        break;
                }
            }
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage(), [
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ]);
        }


        return Command::SUCCESS;
    }
}
