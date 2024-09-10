<?php

namespace Iam\Delivery\Http\Controller\Public;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Iam\Delivery\Http\Request\Dto\User;
use RdKafka\Conf;
use RdKafka\Producer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use const Iam\Delivery\Http\Controller\RD_KAFKA_PARTITION_UA;

class IndexController extends Controller
{
    /**
     * @param User $user
     * @return JsonResponse
     * @throws \ReflectionException
     */
    #[Route('/', name: 'index', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(): JsonResponse
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $producer = new Producer($conf);

        if ($producer->addBrokers("kafka:9092") < 1) {
            echo "Failed adding brokers\n";
            exit;
        }

        $topic = $producer->newTopic("real-topic");


        if (!$producer->getMetadata(false, $topic, 2000)) {
            echo "Failed to get metadata, is broker down?\n";
            exit;
        }

        $msg = 'trolololo_' . date('H:i:s');
        var_dump($msg);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);

        $producer->flush(10000);

        echo "Message published\n";
        return new JsonResponse();
    }
}
