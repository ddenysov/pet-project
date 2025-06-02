<?php
declare(strict_types=1);

namespace Denysov\Demo\Domain\Model\Ping;

use Zinc\Core\Domain\Value\Uuid;
use Zinc\Core\Domain\Value\UuidInterface;

class PingId extends Uuid implements UuidInterface
{

}