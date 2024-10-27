<?php

namespace Track\Domain\Repository\Port;

use Track\Domain\Entity\Track;

interface TrackRepository
{
    /**
     * @param Track $entity
     * @return void
     */
    public function save(Track $entity): void;
}