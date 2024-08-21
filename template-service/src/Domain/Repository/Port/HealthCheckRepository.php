<?php

namespace Template\Domain\Repository\Port;

use Common\Domain\ValueObject\Uuid;
use Template\Domain\Entity\Healthcheck;

interface HealthCheckRepository
{
    /**
     * @param Uuid $id
     * @return Healthcheck
     */
    public function find(Uuid $id): Healthcheck;

    /**
     * @param Healthcheck $entity
     * @return void
     */
    public function save(Healthcheck $entity): void;
}