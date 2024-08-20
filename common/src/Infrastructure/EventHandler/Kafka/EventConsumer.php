<?php

namespace Common\Infrastructure\EventHandler\Kafka;

use Common\Application\EventHandler\EventConsumer as EventConsumerBase;
use Common\Application\EventHandler\Message\EmptyMessage;
use Common\Application\EventHandler\Message\Message;
use Common\Application\EventHandler\Message\Port\Message as MessagePort;
use Common\Application\EventHandler\Message\TimeoutMessage;
use Common\Application\EventHandler\Port\EventConsumer as EventConsumerPort;
use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Exception;
use RdKafka\Topic;
use RdKafka\TopicConf;

class EventConsumer extends EventConsumerBase implements EventConsumerPort
{
    /**
     * @var Conf
     */
    private Conf $configuration;

    /**
     * @var Consumer
     */
    private Consumer $consumer;

    /**
     * @var TopicConf
     */
    private TopicConf $topicConfiguration;

    /**
     * @var Topic
     */
    private Topic     $topic;

    /**
     * @param $message
     * @return Message
     */
    public function transformMessage($message): Message
    {
        $payload = json_decode($message->payload, true);
        $payload = $payload['payload'] ?? [];
        $name    = json_decode($message->payload)->name;

        return new Message($name, $payload);
    }


    /**
     * @param $group
     * @param $topic
     * @return void
     * @throws Exception
     */
    protected function beforeRun($group, $topic)
    {
        $this->init($group, $topic);
    }

    /**
     * @param string $group
     * @param string $topic
     * @return void
     * @throws Exception
     */
    private function init(string $group, string $topic): void
    {
        $this->configuration = new Conf();
        $this->configuration->set('group.id', $group);
        $this->configuration->set('enable.partition.eof', 'true');
        $this->consumer = new Consumer($this->configuration);
        $this->consumer->addBrokers("kafka:9092");
        $this->topicConfiguration = new TopicConf();
        $this->topicConfiguration->set('auto.commit.interval.ms', 100);
        $this->topicConfiguration->set('offset.store.method', 'broker');
        $this->topicConfiguration->set('auto.offset.reset', 'earliest');
        $this->topic = $this->consumer->newTopic($topic, $this->topicConfiguration);
        $this->topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
    }

    /**
     * @param string $group
     * @param string $topic
     * @return MessagePort
     * @throws \Exception
     */
    protected function consumeMessage(string $group, string $topic): MessagePort
    {
        $message = $this->topic->consume(0, 120 * 10000);

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                $result = $this->transformMessage($message);

                break;
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                $result = new EmptyMessage();

                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                $result = new TimeoutMessage();

                break;
            default:
                throw new \Exception($message->errstr());
        }

        return $result;
    }
}