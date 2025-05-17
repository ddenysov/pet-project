<?php

namespace Zinc\Core\Event;

interface EventStore
{
    public function append(EventStream $stream): void;
}