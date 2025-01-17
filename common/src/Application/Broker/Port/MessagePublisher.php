<?php

namespace Common\Application\Broker\Port;

interface MessagePublisher
{
    /**
     * @return void
     */
    public function publish(): void;
}