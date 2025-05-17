<?php
declare(strict_types=1);

namespace Zinc\Core\Message\Outbox;

use Zinc\Core\DataStore\DataStore;
use Zinc\Core\Domain\Event\EventStream;

class Outbox
{
    public function __construct(private DataStore $dataStore)
    {
    }

    public function saveStream(EventStream $stream)
    {

    }
}