<?php
declare(strict_types=1);

namespace Zinc\Core\Command\Middleware\Decorator;

use Zinc\Core\Command\Command;
use Zinc\Core\Command\CommandHandler;
use Zinc\Core\Command\Middleware\CommandHandlerMiddleware;

final class MiddlewareCommandHandlerDecorator implements CommandHandler
{
    /** @var CommandHandlerMiddleware */
    private array $middlewares;

    public function __construct(
        private CommandHandler   $coreHandler,
        CommandHandlerMiddleware ...$middlewares,
    )
    {
        $this->middlewares = $middlewares;
    }

    public function __invoke(Command $command): mixed
    {
        // Строим «луковицу»: последним идёт сам handler
        $pipeline = array_reduce(
            $this->middlewares,

            // Оборачиваем следующий вызов в текущий middleware
            /** @param callable(Command):mixed $next */
            fn (callable $next, CommandHandlerMiddleware $mw): callable =>
            fn (Command $cmd) => $mw->handle($cmd, $next),

            $this->coreHandler,   // ← здесь просто объект-хендлер, а не $this->coreHandler(...)
        );

        return $pipeline($command); // пуск цепочки
    }
}