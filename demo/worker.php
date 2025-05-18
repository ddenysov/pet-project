<?php

require __DIR__ . '/vendor/autoload.php';

use Nyholm\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;

use Spiral\RoadRunner\Worker;
use Spiral\RoadRunner\Http\PSR7Worker;
use VideoValidator\ConfigLoader;
use VideoValidator\FFprobe;
use VideoValidator\FileInfo;
use VideoValidator\RuleFactory;
use VideoValidator\VideoValidator;

$worker = Worker::create();

$factory = new Psr17Factory();

$psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

while (true) {
    try {
        $request = $psr7->waitRequest();
        if ($request === null) {
            break;
        }
    } catch (\Throwable $e) {
        $psr7->respond(new Response(400));
        continue;
    }

    try {
        $startMem  = memory_get_usage();
        $startPeak = memory_get_peak_usage(true);
        $start     = microtime(true);

        $url = '';

        $validator = new VideoValidator(
            new FFprobe(),
            new FileInfo(),
            new RuleFactory(),
            new ConfigLoader(),
        );

        $errors = [];
        foreach ($validator->validate($url, 'config/video_rules.php') as $v) {
            $errors[] = $v->message;
        }

        $end     = microtime(true);
        $endMem  = memory_get_usage();
        $endPeak = memory_get_peak_usage(true);


        $psr7->respond(new Response(200, [], json_encode(
            [
                'errors' => $errors,
                'debug'  => [
                    'profile' => sprintf(
                        "Δ mem: %.2f MB   peak: %.2f MB   time: %.2f ms",
                        ($endMem - $startMem) / 1048576,
                        $endPeak / 1048576,
                        ($end - $start) * 1000
                    ),
                ],
            ],
            JSON_PRETTY_PRINT
        )));
    } catch (\Throwable $e) {
        $psr7->respond(new Response(500, [], $e->getMessage()));
        $psr7->getWorker()->error((string) $e);
    }
}
