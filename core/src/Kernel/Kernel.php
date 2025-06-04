<?php
declare(strict_types=1);

namespace Zinc\Core\Kernel;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zinc\Core\Container\Symfony\SymfonyHttpKernel;
use Zinc\Core\Logging\Logger;

class Kernel
{

    private SymfonyHttpKernel     $kernel;
    private ContainerInterface    $container;
    private HttpFoundationFactory $httpFactory;

    public function __construct(private KernelConfig $config)
    {
        $this->kernel = new SymfonyHttpKernel($this->config);
        $this->kernel->boot();
        $this->container   = $this->kernel->getContainer();
        $this->httpFactory = new HttpFoundationFactory();
        $logger            = $this->container->get(LoggerInterface::class);
        Logger::setLogger($logger);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $symfonyRequest = $this->httpFactory->createRequest($request);
        $symfonyResponse = $this->kernel->handle($symfonyRequest);

        return new Response(
            $symfonyResponse->getStatusCode(),
            $symfonyResponse->headers->all(),
            $symfonyResponse->getContent()
        );
    }
}