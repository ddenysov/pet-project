<?php

namespace Common\Domain\Event;

use ArrayAccess;
use Common\Utils\Collection\Collection;
use InvalidArgumentException;
use Iterator;

class EventStream extends Collection implements Port\EventStream
{

}