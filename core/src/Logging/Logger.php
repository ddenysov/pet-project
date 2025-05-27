<?php
declare(strict_types=1);

namespace Zinc\Core\Logging;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Logger
{
    /** @var LoggerInterface|null */
    private static ?LoggerInterface $logger = null;

    public function __construct() { }

    public static function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    private static function getLogger(): LoggerInterface
    {
        if (self::$logger === null) {
            self::$logger = new NullLogger();
        }
        return self::$logger;
    }

    public static function emergency(string $message, array $context = []): void
    {
        self::getLogger()->emergency($message, $context);
    }

    public static function alert(string $message, array $context = []): void
    {
        self::getLogger()->alert($message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::getLogger()->warning($message, $context);
    }

    public static function notice(string $message, array $context = []): void
    {
        self::getLogger()->notice($message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    public static function log(string $level, string $message, array $context = []): void
    {
        self::getLogger()->log($level, $message, $context);
    }
}