<?php

namespace Iam;

use Common\Application\Bus\Port\EventBus as EventBusPort;
use Common\Infrastructure\Bus\Event\EventBus;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;


}
