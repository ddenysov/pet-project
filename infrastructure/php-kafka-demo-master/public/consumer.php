<?php

$conf = new RdKafka\Conf();
$conf->set('log_level', (string) LOG_DEBUG);
$consumer = new \RdKafka\Consumer($conf);

$consumer->addBrokers("kafka:9092");

$topic = $consumer->newTopic("test-topic");

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


