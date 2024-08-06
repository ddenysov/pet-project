<?php

use RdKafka\Conf;
use RdKafka\Producer;

$conf = new Conf();
$conf->set('log_level', (string) LOG_DEBUG);
$producer = new Producer($conf);

if ($producer->addBrokers("kafka:9092") < 1) {
    echo "Failed adding brokers\n";
    exit;
}

$topic = $producer->newTopic("test-topic");

var_dump($topic);

if (!$producer->getMetadata(false, $topic, 2000)) {
    echo "Failed to get metadata, is broker down?\n";
    exit;
}

$msg = $_SERVER['QUERY_STRING'];
var_dump($msg);

$topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);

$producer->flush(10000);

echo "Message published\n";
