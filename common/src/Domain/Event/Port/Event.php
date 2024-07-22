<?php

namespace Common\Domain\Event\Port;

use Common\Domain\ValueObject\Uuid;

interface Event
{
    public function getId();

    public function setId(Uuid $id);
}