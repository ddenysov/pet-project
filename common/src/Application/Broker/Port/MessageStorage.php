<?php

namespace Common\Application\Broker\Port;

interface MessageStorage
{
    public function store(Message $message): void;

    public function getInboxMessages();
}