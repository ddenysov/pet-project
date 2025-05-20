<?php
declare(strict_types=1);

namespace Denysov\Demo\Container;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class SymfonyHttpKernel extends BaseKernel
{
    use MicroKernelTrait;
}