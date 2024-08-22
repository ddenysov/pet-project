<?php

namespace Common\Infrastructure\Log\Monolog;

use Common\Application\Container\Port\ServiceContainer;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EnvProcessor implements ProcessorInterface
{

    // method is called for each log record; optimize it to not hurt performance
    public function __construct(protected ParameterBagInterface $params)
    {
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['env'] = strtoupper($this->params->get('app_name'));

        return $record;
    }
}